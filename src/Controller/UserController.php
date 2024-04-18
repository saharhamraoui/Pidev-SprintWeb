<?php

namespace App\Controller;

use App\Entity\User;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;



#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/load-user-content/{iduser}', name: 'load_user_content', methods: ['GET'])]
    public function loadUserContent(UserRepository $userRepository, $iduser): Response
    {   
        $writer = new PngWriter();
    
        $user = $userRepository->find($iduser);
        $userData = $user->getUserDataForQrCode();
        $qrCode = new QrCode($userData);
    
        $pngResult = $writer->write($qrCode);
        $qrCodeImage = base64_encode($pngResult->getString());
    
        return $this->render('user/qr.html.twig', [  
            'user'        => $user,
            'qrCodeImage' => $qrCodeImage,
        ]);
    
    }

    
    #[Route('/pdfGenerator', name: 'app_user_pdf',methods: ['GET', 'POST'])]
    public function exportPdf(UserRepository $userRepository): Response
    {
        $users=$userRepository->findAll();
        $html = $this->renderView('user/pdf.html.twig', ['users' => $users]);
    
        // Set up Dompdf options and render the PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        
        $dompdf = new Dompdf();
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->render();
        
        // Return the PDF as a response
        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    #[Route('/statistiques', name: 'statistiques')]
public function indexx(UserRepository $userRepository): Response
{
    $statsLocation = $userRepository->countUsersByLocation();

    return $this->render('user/lieu.html.twig', [
        'statsLocation' => $statsLocation,
    ]);
}

#[Route('/signin', name: 'signin')]
public function signin(): Response
{

    return $this->render('user/signin.html.twig', [
        
    ]);
}


#[Route('/generateExcel', name: 'excel')]
public function generateExcel(UserRepository $userRepository): BinaryFileResponse
{
    $users = $userRepository->findAll();

    // Create a new Spreadsheet instance
    $spreadsheet = new Spreadsheet();

    // Get the active sheet
    $sheet = $spreadsheet->getActiveSheet();

    // Set the headers
    $sheet->setCellValue('A1', 'IdUser');
    $sheet->setCellValue('B1', 'Email');
    $sheet->setCellValue('C1', 'FirstName');
    $sheet->setCellValue('D1', 'LastName');
    $sheet->setCellValue('E1', 'Address');
    $sheet->setCellValue('F1', 'Number');
    $sheet->setCellValue('G1', 'Rating');
    $sheet->setCellValue('H1', 'Picture');

    // Populate data
    $row = 2;
    foreach ($users as $user) {
        /** @var User $user */
        $sheet->setCellValue('A' . $row, $user->getIduser());
        $sheet->setCellValue('B' . $row, $user->getEmail());
        $sheet->setCellValue('C' . $row, $user->getFirstname());
        $sheet->setCellValue('D' . $row, $user->getLastname());
        $sheet->setCellValue('E' . $row, $user->getAddress());
        $sheet->setCellValue('F' . $row, $user->getNumber());
        $sheet->setCellValue('G' . $row, $user->getRating());
        $sheet->setCellValue('H' . $row, $user->getPicture());
        $row++;
    }

    // Create a new Xlsx writer
    $writer = new Xlsx($spreadsheet);

    // Generate a temporary file name
    $fileName = 'Users.xlsx';
    $temp_file = tempnam(sys_get_temp_dir(), $fileName);

    // Save the spreadsheet to the temporary file
    $writer->save($temp_file);

    // Return the file as a BinaryFileResponse
    return new BinaryFileResponse($temp_file, 200, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'Content-Disposition' => sprintf('inline; filename="%s"', $fileName),
    ]);
}

#[Route('/statistiquesRoles', name: 'statistiquesRoles')]
public function roleStats(UserRepository $userRepository): Response
{
    $statsRole = $userRepository->countUsersByRole();

    return $this->render('user/role.html.twig', [
        'statsRole' => $statsRole,
    ]);
}

    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
        }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
   


    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(UserPasswordHasherInterface $userPasswordHasher,SluggerInterface $slugger,Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            $brochureFile = $form->get('picture')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
               
                $newFilename = md5(uniqid()).'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e)
                 {
                    // ... handle exception if something happens during file upload
                }
                $user->setPicture($newFilename);
                $entityManager->persist($user);
                $entityManager->flush();
           

            }

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{iduser}', name: 'app_user_showw', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    
 
    #[Route('/{iduser}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('picture')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
               
                $newFilename = md5(uniqid()).'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e)
                 {
                    // ... handle exception if something happens during file upload
                }
                $user->setPicture($newFilename);
            // Persist changes to the database
            $entityManager->flush();
            }
            // Redirect the user to the user index page
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{iduser}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getIduser(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
