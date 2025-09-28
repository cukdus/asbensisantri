<?php

namespace App\Libraries\Whatsapp\Waha;

class WahaMessage
{
    public function __construct(
        private string $destination,
        private string $message,
        private int $delay = 2
    ) {}

    public function toArray(): array
    {
        return [
            'chatId' => $this->formatPhoneNumber($this->destination) . '@c.us',
            'text' => $this->message,
            'session' => 'default'
        ];
    }

    private function formatPhoneNumber(string $phoneNumber): string
    {
        // Hapus karakter non-numerik
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Pastikan format nomor telepon benar (awalan 62)
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        } else if (substr($phoneNumber, 0, 2) !== '62') {
            $phoneNumber = '62' . $phoneNumber;
        }

        return $phoneNumber;
    }
}
