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
        $donationValue = floatval($requestData['valeurdon']);

        // Assuming the donation value is sent as JSON in the request body

        // Initiate the payment
        $paymentResponse = $this->KonnectPaymentService->initPayment($donationValue);

        return new JsonResponse(['payUrl' => $paymentResponse->getPayUrl()]);
    }
    

    #[Route('/new', name: 'app_donation_new', methods: ['GET'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($donation);
            $entityManager->flush();

            return $this->redirectToRoute('initiate_payment', [], Response::HTTP_SEE_OTHER);
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
}
