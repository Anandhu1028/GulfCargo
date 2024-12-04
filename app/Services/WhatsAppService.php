<?php

    namespace App\Services;

    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\RequestException;
    use Illuminate\Support\Facades\Log;

    class WhatsAppService
    {
        protected $client;
        protected $vendorUid;

        public function __construct()
        {
            $this->client = new Client([
                'base_uri' => env('WHATSAPP_API_BASE_URL'),
                'headers' => [
                    'Authorization' => 'Bearer ' . env('WHATSAPP_API_BEARER_TOKEN'),
                ],
                'debug' => true,
            ]);

            $this->vendorUid = env('WHATSAPP_API_VENDOR_ID');
        }

        public function sendMessage($data)
        {
            try {
                $url = "{$this->vendorUid}/contact/send-template-message";
                Log::info('Sending WhatsApp message', ['url' => $url, 'data' => $data]);

                // Ensure $data contains all the required fields as per API documentation
                $response = $this->client->post($url, [
                    'json' => $data,
                ]);

                $responseBody = json_decode($response->getBody()->getContents(), true);

                Log::info('WhatsApp message sent successfully', ['response' => $responseBody]);

                return $responseBody;
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
                    Log::error('WhatsApp message failed', ['error' => $errorResponse]);
                    return $errorResponse;
                }

                Log::error('WhatsApp message failed', ['error' => $e->getMessage()]);
                return ['error' => $e->getMessage()];
            }
        }

    }

