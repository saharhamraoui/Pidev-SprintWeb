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
        ->to('saaharhamraoui@gmail.com') 
        ->subject('Signed up ')
        ->text('Your inscription has been confirmed.');

        $mailer->send($email);

        return new Response(
            'Email sent successfully'
         );
    }
    
}
