<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
        ->from('greenmenu2024@outlook.com') 
        ->to('nader123mb456@gmail.com') 
        ->subject(' Donation Completed ')
        ->text('Your Donation has been confirmed.');

        $mailer->send($email);

        return $this->redirectToRoute('app_donate_index', [], Response::HTTP_SEE_OTHER);  }
    
}