<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Commande;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Form\CommandeType;
use App\Form\commandeFrontType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande')]
class CommandeController extends AbstractController
{

    #[Route('/mailer', name: 'app_mailer')]
    public function sendEMail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('greenmenu2024@outlook.com')
            ->to('dorsafriahi6@gmail.com')
            ->subject('Confirmation')
            ->text('your order has been added successfully.');


        $mailer->send($email);


        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/TemplateFrontCommande', name: 'app_commande_front')]
    public function frontCommande(): Response
    {
        return $this->render('commandeFront/cart.html.twig', []);
    }
    #[Route('/CommandeChekOut', name: 'CommandeChekOut', methods: ['GET', 'POST'])]
    public function newFront(CommandeRepository $repo, Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande1 = $repo->find(24);
        $commande = new Commande();
        $commande->setIduser($commande1->getIduser());
        $commande->setRestaurantid($commande1->getRestaurantid());
        $commande->setMontanttotalcommande(500);
        $form = $this->createForm(commandeFrontType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commandeFront/checkout.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }


    #[Route('/pdfGenerator', name: 'app_user_pdf', methods: ['GET', 'POST'])]
    public function exportPdf(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findAll();
        $html = $this->renderView('commande/pdf.html.twig', ['commandes' => $commandes]);

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

    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_mailer', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }



    #[Route('/{idcommande}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }




    #[Route('/{idcommande}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{idcommande}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commande->getIdcommande(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
