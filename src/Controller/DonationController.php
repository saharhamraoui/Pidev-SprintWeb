<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Form\DonationType;
use App\Repository\DonationRepository;
use App\Repository\CampaignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use VictorPrad\RecaptchaBundle\Validator\Constraints as Recaptcha;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/donation')]
class DonationController extends AbstractController
{
    #[Route('/', name: 'app_donation_index', methods: ['GET'])]
    public function index(DonationRepository $donationRepository): Response
    {
        return $this->render('donation/index.html.twig', [
            'donations' => $donationRepository->findAll(),
        ]);
    }
    #[Route('/f', name: 'app_donation_indexf', methods: ['GET'])]
    public function indexf(DonationRepository $donationRepository): Response
    {
        return $this->render('donation/indexf.html.twig', [
            'donations' => $donationRepository->findAll(),
        ]);
    }
    #[Route('/initiate-payment', name: 'initiate_payment', methods: ['POST'])]
    public function initiatePayment(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $donationValue = floatval($requestData['donationValue']);

        // Assuming the donation value is sent as JSON in the request body

        // Initiate the payment
        $paymentResponse = $this->paymentService->initPayment($donationValue);

        return new JsonResponse(['payUrl' => $paymentResponse->getPayUrl()]);
    }
    

   /* #[Route('/new', name: 'app_donation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($donation);
            $entityManager->flush();

            return $this->redirectToRoute('app_donation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donation/new.html.twig', [
            'donation' => $donation,
            'form' => $form,
        ]);
    }
    #[Route('/newf', name: 'app_donation_newf', methods: ['GET', 'POST'])]
    public function newf(Request $request, EntityManagerInterface $entityManager): Response
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($donation);
            $entityManager->flush();

            return $this->redirectToRoute('app_donation_indexf', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donation/newf.html.twig', [
            'donation' => $donation,
            'form' => $form,
        ]);
    }

    */


    #[Route('/new', name: 'app_donation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request); 
    
        if ($form->isSubmitted() && $form->isValid()) {
            $amount = $donation->getValeurDon();
            $entityManager->persist($donation);
            $entityManager->flush();
            $email = (new Email())
            ->from('greenmenu2024@outlook.com') 
            ->to('nader123mb456@gmail.com') 
            ->subject(' Donation Completed ')
            ->text('Your Donation has been confirmed.');
    
            $mailer->send($email);
    
        
                if ($amount === 100) {
                    $this->redirectToRoute('app_mailer', [], Response::HTTP_SEE_OTHER);
                    return $this->redirect('https://gateway.sandbox.konnect.network/pay?payment_ref=663283cbd65ce91d9ed1ce16');
                } elseif ($amount === 300) {
                    $this->redirectToRoute('app_mailer', [], Response::HTTP_SEE_OTHER);
    
                    return $this->redirect('https://gateway.sandbox.konnect.network/pay?payment_ref=66328410d65ce91d9ed1ced0');
                }elseif ($amount === 500) {
                    $this->redirectToRoute('app_mailer', [], Response::HTTP_SEE_OTHER);
    
                    return $this->redirect('https://gateway.sandbox.konnect.network/pay?payment_ref=66328684d65ce91d9ed1e988');
                } else {
                    // Handle other amounts if needed
                    // For now, redirect to a default route
                    return $this->redirect('https://gateway.sandbox.konnect.network/pay?payment_ref=66328684d65ce91d9ed1e988');
               }
            }
    
        return $this->renderForm('donation/new.html.twig', [
            'donation' => $donation,
            'form' => $form,
        ]);
    }
    
    #[Route('/newf', name: 'app_donation_newf', methods: ['GET', 'POST'])]
    public function newf(Request $request, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $amount = $donation->getValeurDon();
            $entityManager->persist($donation);
            $entityManager->flush();
            
            $email = (new Email())
        ->from('greenmenu2024@outlook.com') 
        ->to('nader123mb456@gmail.com') 
        ->subject(' Donation Completed ')
        ->text('Your Donation has been confirmed.');

        $mailer->send($email);

    
            if ($amount === 100) {
                $this->redirectToRoute('app_mailer', [], Response::HTTP_SEE_OTHER);
                return $this->redirect('https://gateway.sandbox.konnect.network/pay?payment_ref=663283cbd65ce91d9ed1ce16');
            } elseif ($amount === 300) {
                $this->redirectToRoute('app_mailer', [], Response::HTTP_SEE_OTHER);

                return $this->redirect('https://gateway.sandbox.konnect.network/pay?payment_ref=66328410d65ce91d9ed1ced0');
            }elseif ($amount === 500) {
                $this->redirectToRoute('app_mailer', [], Response::HTTP_SEE_OTHER);

                return $this->redirect('https://gateway.sandbox.konnect.network/pay?payment_ref=66328684d65ce91d9ed1e988');
            } else {
                // Handle other amounts if needed
                // For now, redirect to a default route
                return $this->redirectToRoute('app_donation_indexf', [], Response::HTTP_SEE_OTHER);
            }
        }
    
        return $this->renderForm('donation/newf.html.twig', [
            'donation' => $donation,
            'form' => $form,
        ]);
    }
    


    #[Route('/{iddon}', name: 'app_donation_show', methods: ['GET'])]
    public function show(Donation $donation): Response
    {
        return $this->render('donation/show.html.twig', [
            'donation' => $donation,
        ]);
    }

    #[Route('/{iddon}/f', name: 'app_donation_showf', methods: ['GET'])]
    public function showf(Donation $donation): Response
    {
        return $this->render('donation/showf.html.twig', [
            'donation' => $donation,
        ]);
    }

    #[Route('/{iddon}/edit', name: 'app_donation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Donation $donation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_donation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donation/edit.html.twig', [
            'donation' => $donation,
            'form' => $form,
        ]);
    }
    

    #[Route('/{iddon}', name: 'app_donation_delete', methods: ['POST'])]
    public function delete(Request $request, Donation $donation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donation->getIddon(), $request->request->get('_token'))) {
            $entityManager->remove($donation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_donation_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{iddon}/f', name: 'app_donation_deletef', methods: ['POST'])]
    public function deletef(Request $request, Donation $donation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donation->getIddon(), $request->request->get('_token'))) {
            $entityManager->remove($donation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_donation_indexf', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/pdfGenerator', name: 'app_user_pdf',methods: ['GET', 'POST'])]
    public function exportPdf(DonationRepository $userRepository): Response
    {
        $users=$userRepository->findAll();
        $html = $this->renderView('donation/index.html.twig', ['donations' => $users]);
    
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
}
