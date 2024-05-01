<?php

namespace App\Controller;

use App\Entity\Cabinet;
use App\Form\CabinetType;
use App\Repository\CabinetRepository;
use App\Repository\RdvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;


#[Route('/cabinet')]
class CabinetController extends AbstractController
{
    #[Route('/', name: 'app_cabinet_index', methods: ['GET'])]
    public function index(CabinetRepository $cabinetRepository, RdvRepository $rdvRepository): Response
    {
        $cabinets = $cabinetRepository->findAll();
        $nombreRdvParCabinet = [];

        foreach ($cabinets as $cabinet) {
            $nombreRdv = $rdvRepository->countRdvByCabinetId($cabinet->getId());
            $nombreRdvParCabinet[$cabinet->getId()] = $nombreRdv;
        }
        return $this->render('cabinet/index.html.twig', [
            'nbs' => $nombreRdvParCabinet,
            'cabinets' => $cabinetRepository->findAll(),
        ]);
    }

    #[Route('/front', name: 'app_cabinet_index_front', methods: ['GET'])]
    public function indexFront(CabinetRepository $cabinetRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $data=$cabinetRepository->findAll();

        $cabinets=$paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            3
        );

        return $this->render('cabinet/indexFront.html.twig', [
            'cabinets' => $cabinets,
        ]);
    }
    

    #[Route('/{id}/pdf', name: 'app_cabinet_pdf', methods: ['GET'])]     
    public function AfficheTicketPDF(CabinetRepository $repo, $id)
    {
        $pdfoptions = new Options();
        $pdfoptions->set('defaultFont', 'Arial');
        $pdfoptions->setIsRemoteEnabled(true);
        

        $dompdf = new Dompdf($pdfoptions);

        $cabinets = $repo->find($id);

        // Check if the cabinet exists
        if (!$cabinets) {
            throw $this->createNotFoundException('Your Cabinet does not exist');
        }

        $html = $this->renderView('cabinet/pdfExport.html.twig', [
            'cabinet' => $cabinets
        ]);

        $html = '<div>' . $html . '</div>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A6', 'landscape');
        $dompdf->render();

        $pdfOutput = $dompdf->output();

        return new Response($pdfOutput, Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="cabinetPDF.pdf"'
        ]);
    }

    #[Route('/new', name: 'app_cabinet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cabinet = new Cabinet();
        $form = $this->createForm(CabinetType::class, $cabinet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cabinet);
            $entityManager->flush();

            return $this->redirectToRoute('app_cabinet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cabinet/new.html.twig', [
            'cabinet' => $cabinet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cabinet_show', methods: ['GET'])]
    public function show(Cabinet $cabinet): Response
    {
        return $this->render('cabinet/show.html.twig', [
            'cabinet' => $cabinet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cabinet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cabinet $cabinet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CabinetType::class, $cabinet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cabinet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cabinet/edit.html.twig', [
            'cabinet' => $cabinet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cabinet_delete', methods: ['POST'])]
    public function delete(Request $request, Cabinet $cabinet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cabinet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cabinet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cabinet_index', [], Response::HTTP_SEE_OTHER);
    }
}