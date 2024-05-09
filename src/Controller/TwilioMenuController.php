<?php

namespace App\Controller;


use Twilio\Rest\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TwilioMenuController extends AbstractController
{

    #[Route('/smsMenu', name: 'send_smsMenu')]

    public function sendSms(): Response
    {
        $sid = 'AC94cd8c2410409dd2d20ddd449a4c82a0';
        $token = 'c9d39ede64fad01e9614947e954aa521';
        $client = new Client($sid, $token);

        $toNumber = '+21692098364'; // Replace with the recipient's phone number
        $fromNumber = '+19782917692';
        $message = 'Check menu updated!';

        $client->messages->create($toNumber, [
            'from' => $fromNumber,
            'body' => $message,
        ]);

        return new Response('SMS sent successfully.');
    }
}
