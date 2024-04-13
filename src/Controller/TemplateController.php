<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{

    #[Route('/templateDeconnected', name: 'app_template')]
    public function index2(): Response
    {
        return $this->render('baseFrontDeconnected.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    #[Route('/templateConnected', name: 'app_template')]
    public function index(): Response
    {
        return $this->render('baseFront.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
}
