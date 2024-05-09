<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
// use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Symfony\Component\Routing\Annotation\Route;

class RecetteController extends AbstractController
{
    /* #[Route('/recette', name: 'app_recette')]
    public function index(): Response
    {
        // Fetch the list of recipes from the database

        $recettes = $this->getDoctrine()
        ->getRepository(Recette::class)
        ->findAllWithIngredients();

    return $this->render('recette/index.html.twig', [
        'recettes' => $recettes,
    ]);
    } */

    /*#[Route('/recette', name: 'app_addRecette2')]
    public function addRecette(): Response
    {
        return $this->render('Recette/addRecette.html.twig', [
            'controller_name' => 'RecetteController',
        ]);
    }*/

    #[Route('/recette/{id}', name: 'recette_show')]
    public function show(Recette $recette): Response
    {
        
        return $this->render('recette/recetteFront.html.twig', [
            'recette' => $recette,
        ]);
    }

    #[Route('/listRecetteFront', name: 'recetteList_showFront')]
    public function showRecettesF(RecetteRepository $recetteRepository): Response
    {
        //$recettes = $recetteRepository->findAll();
        $recettes = $recetteRepository->findValidRecipes();

        return $this->render('recette/listRecetteFront.html.twig', [
            'controller_name' => 'RecetteController',
            'recettes'  => $recettes,
        ]);
    }

    #[Route('/addRecette', name: 'app_addRecette')]
    public function new(Request $request, ManagerRegistry $doctrine) : Response {
        $entityManager = $doctrine->getManager();
        // creates a recipe object and initializes some data for this example
        $recette = new Recette();
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($recette);
        $form = $this->createForm(RecetteType::class, $recette); 

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $data = $form->getData();

            $prepHour = $form->get('prepHour')->getData();
            $prepMin = $form->get('prepMin')->getData();
            $recette->setPrep($prepHour,$prepMin);

            // Set other form data to entity properties
            $recette->setServes($data->getServes());
            $recette->setDescription($data->getDescription());
            $recette->setDate($data->getDate());
            $recette->setRating($data->getRating());
            $recette->setImagerec($data->getImagerec());
            $recette->setNomrec($data->getNomrec());
            $recette->setCategoryr($data->getCategoryr());
            $recette->setDifficulty($data->getDifficulty());            
            // dump($recette); for debugging
            // TODO ... perform some action, such as saving the task to the database
            $entityManager->flush();
            $this->addFlash('success', 'Recipe added successfully!');
            return $this->redirectToRoute('app_recette_getAll');
        }
        // rendering the form
        return $this->render('recette/addRecette.html.twig', [
            'form' => $form->createView(),
        ]);
             
    }

    #[Route('/recetteList', name: 'app_recette_getAll')]
    public function showRecettes(RecetteRepository $recetteRepository): Response
    {
        $recettes = $recetteRepository->findAll();
        

        return $this->render('recette/showRecettes.html.twig', [
            'controller_name' => 'RecetteController',
            'recettes'  => $recettes,
        ]);
    }

    #[Route('/recetteing/{id}', name: 'app_recette_ing')]
    public function showing(RecetteRepository $recetteRepository,int $id): Response
    {
        return $this->render('ingredients/showIngredients.html.twig', [
            'controller_name' => 'IngredientsController',
            'id' => $id,
        ]);
    }

    #[Route('/deleteRec/{id}', name: 'app_recette_delete')]
    public function deleteRecette(ManagerRegistry $doctrine, RecetteRepository $recetteRepository, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $recette = $recetteRepository->find($id);
        $entityManager->remove($recette);
        $entityManager->flush();
        return $this->redirectToRoute('app_recette_getAll');
    }

    #[Route('/editRecette/{id}', name: 'app_recette_edit')]
    public function editRecette(ManagerRegistry $doctrine,Request $request, Recette $recette , RecetteRepository $recetteRepository, int $id): Response
    {
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            // $entityManager->persist($product), but it isn't necessary: 
            // Doctrine is already "watching" your object for changes.
            $entityManager->flush();
            $this->addFlash('success', 'post.updated_successfully');

            return $this->redirectToRoute('app_recette_getAll');
        }
        
        return $this->render('recette/editRecette.html.twig', [
            'recette' => $recette,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/recette/{id}/pdf', name: 'recipe_pdf')]
    public function PDF_Recette($id, RecetteRepository $recetteRepository)
    {
        $recipe = $recetteRepository->find($id);
    
        if (!$recipe) {
            return $this->json([
                'status' => 'error',
                'message' => 'Recette non trouvée'
            ]);
        }
    
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
    
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('recette/pdfRecette.html.twig', [
            'recette' => $recipe,
        ]);
    
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $output = $dompdf->output();
    
        $filename = 'recette.pdf'; // Set the desired filename
    
        // Save the PDF file to the server
        file_put_contents($filename, $output);
    
        // Create a response to initiate the file download
        $response = new Response(file_get_contents($filename));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        ));
    
        // Delete the temporary PDF file from the server
        unlink($filename);
    
        return $response;
    }

    #[Route('/recette/{id}/email', name: 'recipe_email')]
public function email($id, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
{
    $recipe = $entityManager->getRepository(Recette::class)->find($id);
    $recipe->setEtatvalide('valide');
    $entityManager->flush();
    if (!$recipe) {
        return $this->json([
            'status' => 'error',
            'message' => 'Recette non trouvée'
        ]);
    }

    $email = (new Email())
        ->from('zeineb.kr.56@gmail.com')
        ->to('zeineb.kraiem@esprit.tn')
        ->subject('valid recipe')
        ->html($this->renderView('recette/emailRecette.html.twig', [
            'recette' => $recipe,
        ]));

    $mailer->send($email);

    return $this->redirectToRoute('app_recette_getAll', [
        'id' => $recipe->getIdrec(),
    ]);
}
}



