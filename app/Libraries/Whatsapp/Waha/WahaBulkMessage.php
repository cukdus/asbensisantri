<?php

namespace App\Libraries\Whatsapp\Waha;

class WahaBulkMessage
{
    private array $messages = [];

    public function __construct(array $messages)
    {
        foreach ($messages as $message) {
            $this->addMessage(
                $message['destination'],
                $message['message'],
                $message['delay'] ?? 2
            );
        }
    }

    public function addMessage(string $destination, string $message, int $delay = 2): void
    {
        $this->messages[] = (new WahaMessage($destination, $message, $delay))->toArray();
    }

    public function toJson(): string
    {
        // WAHA API hanya memproses satu pesan dalam satu request
        // Jika ada banyak pesan, kita ambil yang pertama saja
        return json_encode($this->messages[0] ?? []);
    }
}
