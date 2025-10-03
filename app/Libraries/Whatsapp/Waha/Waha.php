<?php

namespace App\Libraries\Whatsapp\Waha;

use App\Libraries\Whatsapp\Whatsapp;
use App\Libraries\WhatsappSettingsService;

class Waha implements Whatsapp
{
    private string $baseUrl;
    private WhatsappSettingsService $settingsService;

    public function __construct(
        ?string $baseUrl = null,
        ?WhatsappSettingsService $settingsService = null
    ) {
        $this->settingsService = $settingsService ?? new WhatsappSettingsService();
        $this->baseUrl = $baseUrl ?? $this->settingsService->getApiUrl();
    }

    public function getProvider(): string
    {
        return 'Waha';
    }

    public function getToken(): string
    {
        // Try to get from database first, fallback to environment
        $token = $this->settingsService->getApiKey();
        if (empty($token)) {
            $token = env('WHATSAPP_TOKEN', '@#Aremania87');
        }
        // Remove quotes if present
        return trim($token, '"\'');
    }

    public function getXApiKey(): string
    {
        return $this->settingsService->getXApiKey();
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
        // Prepare headers
        $headers = ['Content-Type: application/json'];
        
        // Add X-API-Key if available from database
        $xApiKey = $this->getXApiKey();
        if (!empty($xApiKey)) {
            $headers[] = 'x-api-key: ' . $xApiKey;
        } else {
            // Fallback to token-based authentication
            $headers[] = 'x-api-key: ' . $this->getToken();
        }

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
            CURLOPT_HTTPHEADER => $headers,
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
