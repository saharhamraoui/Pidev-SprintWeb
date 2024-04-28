<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Form\CampaignType;
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


#[Route('/campaign')]
class CampaignController extends AbstractController
{
    #[Route('/', name: 'app_campaign_index', methods: ['GET'])]
    public function index(CampaignRepository $campaignRepository): Response
    {
        return $this->render('campaign/index.html.twig', [
            'campaigns' => $campaignRepository->findAll(),
        ]);
    }
    #[Route('/donate', name: 'app_donate_index', methods: ['GET'])]
    public function donate(CampaignRepository $campaignRepository, PaginatorInterface $paginator,Request $request): Response
    {

        $all=$campaignRepository ->findAll();

        $campaigns = $paginator->paginate(
            $all, 
            $request->query->getInt('page', 1), 
            1//
        );
        return $this->render('donation/donate.html.twig', [
            'campaigns' =>  $campaigns ,
           
        ]);
    }
    #[Route('/search', name: 'app_campaign_front', methods: ['GET'])]
    public function indexfront(CampaignRepository $campaignRepository, Request $request): Response
    {
        $title = $request->query->get('titre');
        $name = $request->query->get('associationName');
        $number = $request->query->get('number');
        $type = $request->query->get('campaignType');
        $goal = $request->query->get('goal');
        $title = $title ?? '';
        $name = $name ?? '';
        $number = $number ?? '';
        $type = $type ?? '';
        $goal = $goal ?? '';
        // Utilisation de la méthode findByCombinedSearch pour effectuer la recherche
        $associations = $campaignRepository->findByCombinedSearch( $title,  $name,  $type,  $goal,  $number);
        $allassociation =$campaignRepository ->findAll();
       
        return $this->render('association.html.twig', [
            'associations' =>  $associations
        ]);
    }

    #[Route('/new', name: 'app_campaign_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $a = new Campaign();
        $form = $this->createForm(CampaignType::class, $a);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($a);
            $entityManager->flush();
            $brochureFile = $form->get('image')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

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
                $a->setImage($newFilename);
                $entityManager->persist($a);
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_campaign_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('campaign/new.html.twig', [
            'campaign' => $a,
            'form' => $form,
        ]);
    }
    #[Route('/{idcamp}', name: 'app_campaign_show', methods: ['GET'])]
    public function show(Campaign $campaign): Response
    {
        return $this->render('campaign/show.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    #[Route('/{idcamp}/edit', name: 'app_campaign_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Campaign $campaign, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        $brochureFile = $form->get('image')->getData();

        // this condition is needed because the 'brochure' field is not required
        // so the PDF file must be processed only when a file is uploaded
        if ($brochureFile) {
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

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
            $campaign->setImage($newFilename);
            $entityManager->persist($campaign);
            $entityManager->flush();
            return $this->redirectToRoute('app_campaign_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('campaign/edit.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
        ]);
    }

    #[Route('/{idcamp}', name: 'app_campaign_delete', methods: ['POST'])]
    public function delete(Request $request, Campaign $campaign, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$campaign->getIdcamp(), $request->request->get('_token'))) {
            $entityManager->remove($campaign);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_campaign_index', [], Response::HTTP_SEE_OTHER);
    }
}
