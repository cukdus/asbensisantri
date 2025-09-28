<?php

namespace App\Libraries\Whatsapp\Waha;

use App\Libraries\Whatsapp\Whatsapp;

class Waha implements Whatsapp
{
    private string $baseUrl;

    public function __construct(
        ?string $baseUrl = null
    ) {
        $this->baseUrl = $baseUrl ?? env('WAHA_API_URL', 'https://wasapbro.eqiyu.id');
    }

    public function getProvider(): string
    {
        return 'Waha';
    }

    public function getToken(): string
    {
        $token = env('WHATSAPP_TOKEN', '@#Aremania87');
        // Remove quotes if present
        return trim($token, '"\'');
    }

    /**
     * Send message to WAHA API
     * @param array|string $messages
     * @return string
     */
    public function sendMessage(array|string $messages): string
    {
        $messages = isset($messages[0]) ? $messages : [$messages];
        $wahaBulkMessage = new WahaBulkMessage($messages);
        $curl = curl_init();
        $jsonMessage = $wahaBulkMessage->toJson();

        // Enable verbose output for debugging
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt_array($curl, array(
            CURLOPT_URL => rtrim($this->baseUrl, '/') . '/api/sendText',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonMessage,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'x-api-key: ' . $this->getToken()
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            log_message('error', 'Error sending message to WAHA API: ' . $err);
            return 'Error: ' . $err;
        }

        return $response;
    }
}
