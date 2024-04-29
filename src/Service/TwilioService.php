<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid = 'AC7cd4467f76c6d4c0c290404a3c17df84';
    private $authToken = 'bd2fc656082b0ab5eaee5d181886cd70';
    private $twilioPhoneNumber = '+16562262555';
   
    public function sendSMS()
    {
        $to = '+21654825185'; // Le numéro de téléphone destinataire
        $message = 'you  signed up to our app recruti successfully'; // Le message que vous souhaitez envoyer
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


