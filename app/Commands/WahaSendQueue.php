<?php

namespace App\Commands;

use App\Libraries\Whatsapp\Waha\Waha;
use App\Models\WhatsappQueueModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class WahaSendQueue extends BaseCommand
{
    protected $group = 'Whatsapp';
    protected $name = 'waha:send-queue';
    protected $description = 'Proses satu pesan WAHA dari queue setiap kali dijalankan (rate 1 per menit jika dijadwalkan per menit).';

    public function run(array $params)
    {
        $queue = new WhatsappQueueModel();
        $item = $queue->fetchNext();

        if (!$item) {
            CLI::write('Tidak ada pesan pending untuk dikirim.', 'yellow');
            return;
        }

        $queue->markProcessing((int) $item['id']);

        $waha = new Waha();
        $message = [
            'destination' => $item['destination'],
            'message' => $item['message'],
            'delay' => 0,
        ];

        try {
            $response = $waha->sendMessage($message);
            // Sederhana: anggap berhasil jika tidak mengandung kata 'Error'
            if (is_string($response) && str_contains($response, 'Error')) {
                $queue->markFailed((int) $item['id'], $response);
                CLI::error('Gagal mengirim pesan: ' . $response);
                return;
            }

            $queue->markSent((int) $item['id']);
            CLI::write('Pesan terkirim ke ' . $item['destination'], 'green');
        } catch (\Throwable $e) {
            $queue->markFailed((int) $item['id'], $e->getMessage());
            CLI::error('Exception saat mengirim pesan: ' . $e->getMessage());
        }
    }
}