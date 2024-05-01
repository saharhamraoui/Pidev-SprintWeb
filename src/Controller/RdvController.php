<?php

namespace App\Controller;

use App\Entity\Rdv;
use App\Entity\Cabinet;
use App\Form\RdvType;
use App\Form\RdvFrontType;
use App\Repository\RdvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;



#[Route('/rdv')]
class RdvController extends AbstractController
{
    #[Route('/newFront/{id}', name: 'app_rdv_new_front', methods: ['GET', 'POST'])]
    public function newFront(Request $request, EntityManagerInterface $entityManager, $id, Client $twilioClient): Response
    {
        $rdv = new Rdv();
        $cabinet = new Cabinet();
        $cabinet = $this->getDoctrine()->getManager()->getRepository(Cabinet::class)->find($id);

        $form = $this->createForm(RdvFrontType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rr = $this->filterwords($rdv->getNom());
            $rdv->setNom($rr);
            $rdv->setIdCabinet($cabinet);
            $entityManager->persist($rdv);
            $entityManager->flush();

            $toNumber = '+21651192850';
            $fromNumber = '+13347814193';
            $message = $twilioClient->messages->create(
                $toNumber,
                [
                    'from' => $fromNumber,
                    'body' => 'Un Rendez-Vous a ete ajouté avec succés.',
                ]
            );

            return $this->redirectToRoute('app_rdv_merci', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rdv/newFront.html.twig', [
            'rdv' => $rdv,
            'form' => $form,
        ]);
    }


    #[Route('/', name: 'app_rdv_index', methods: ['GET'])]
    public function index(RdvRepository $rdvRepository): Response
    {
        return $this->render('rdv/index.html.twig', [
            'rdvs' => $rdvRepository->findAll(),
        ]);
    }

    #[Route('/merci', name: 'app_rdv_merci', methods: ['GET'])]
    public function merci(RdvRepository $rdvRepository): Response
    {
        return $this->render('rdv/merci.html.twig', [
            'rdvs' => $rdvRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rdv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Client $twilioClient): Response
    {
        $rdv = new Rdv();
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rr = $this->filterwords($rdv->getNom());
            $rdv->setNom($rr);
            $entityManager->persist($rdv);
            $entityManager->flush();

            $toNumber = '+21651192850';
            $fromNumber = '+13347814193';
            $message = $twilioClient->messages->create(
                $toNumber,
                [
                    'from' => $fromNumber,
                    'body' => 'Un Rendez-Vous a ete ajoute avec succes.',
                ]
            );

            return $this->redirectToRoute('app_rdv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rdv/new.html.twig', [
            'rdv' => $rdv,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rdv_show', methods: ['GET'])]
    public function show(Rdv $rdv): Response
    {
        return $this->render('rdv/show.html.twig', [
            'rdv' => $rdv,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rdv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rdv $rdv, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rdv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rdv/edit.html.twig', [
            'rdv' => $rdv,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rdv_delete', methods: ['POST'])]
    public function delete(Request $request, Rdv $rdv, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rdv->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rdv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rdv_index', [], Response::HTTP_SEE_OTHER);
    }
    public function filterwords($text)
    {
        $filterWords = array('fokaleya', 'bhim', 'msatek', 'fuck', 'shit', 'yezi');
        $filterCount = count($filterWords);
        $str = "";
        $data = preg_split('/\s+/',  $text);
        foreach($data as $s){
            $g = false;
            foreach ($filterWords as $lib) {
                if($s == $lib){
                    $t = "";
                    for($i =0; $i<strlen($s); $i++) $t .= "*";
                    $str .= $t . " ";
                    $g = true;
                    break;
                }
            }
            if(!$g)
            $str .= $s . " ";
        }
        return $str;
    }

}
