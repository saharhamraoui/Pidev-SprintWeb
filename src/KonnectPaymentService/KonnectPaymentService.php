<?php

namespace App\KonnectPaymentService;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

class KonnectPaymentService
{
    private $konnectConfig;
    private $httpClient;
    private $logger;

    public function __construct(KonnectConfig $konnectConfig, HttpClientInterface $httpClient, LoggerInterface $logger)
    {
        $this->konnectConfig = $konnectConfig;
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    public function initPayment(float $amount): ?PayementResponse
    {
        $apiKey = $this->konnectConfig.API_KEY;
        $baseUrl = $this->konnectConfigget.API_URL;
        $receiverWalletId = $this->konnectConfig.PORTFOLIO_ID;

        $url = $baseUrl . "payments/init-payment";

        $payload = [
            'receiverWalletId' => $receiverWalletId,
            'token' => 'TND',
            'amount' => $amount,
            // Add other payload fields here
        ];

        try {
            $response = $this->httpClient->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-api-key' => $apiKey,
                ],
                'json' => $payload,
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                $responseData = $response->toArray();
                // Process response data and return PayementResponse object
                return new PayementResponse(/* pass response data here */);
            } else {
                $this->logger->warning("Non-200 response received: $statusCode");
                return null;
            }
        } catch (\Exception $e) {
            $this->logger->error("Error occurred while initiating payment: " . $e->getMessage());
            return null;
        }
    }
}
