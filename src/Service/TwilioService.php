<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid = 'AC3d6cbd3d48896be7080f380a01830897';
    private $authToken = 'ed823fdc8a292c60e90f6849c1608743';
    private $twilioPhoneNumber = '+12625814027';

    public function sendSMS()
    {
        $to = '+21695075025'; // Le numéro de téléphone destinataire
        $message = 'votre commande sera livré'; // Le message que vous souhaitez envoyer
        $client = new Client($this->accountSid, $this->authToken);
        $client->messages->create(
            $to,
            [
                'from' => $this->twilioPhoneNumber,
                'body' => $message,
            ]
        );
    }
}
