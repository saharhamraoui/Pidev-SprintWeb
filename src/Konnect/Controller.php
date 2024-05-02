<?php

namespace App\Konnect;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller extends AbstractController
{
    

   
    /**
     * @Route("initiate-payment", methods={"POST"})
     */
    public function initiatePayment(Request $request): Response
    {
        // Assuming the amount is sent in the request body as JSON
        $requestData = json_decode($request->getContent(), true);

        // Validate the request data
        if (!isset($requestData['amount']) || !is_numeric($requestData['amount'])) {
            return new Response('Invalid amount', Response::HTTP_BAD_REQUEST);
        }

        // Call the KonnectPaymentService to initiate the payment
        $amount = (float) $requestData['amount'];
        $paymentResponse = $this->konnectPaymentService->initPayment($amount);

        // Check if payment initiation was successful
        if ($paymentResponse !== null) {
            // Payment initiation successful, return success response
            return new Response('Payment initiated successfully', Response::HTTP_OK);
        } else {
            // Payment initiation failed, return error response
            return new Response('Failed to initiate payment', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
