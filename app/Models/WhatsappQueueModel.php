<?php

namespace App\Models;

use CodeIgniter\Model;

class WhatsappQueueModel extends Model
{
    protected $table = 'tb_whatsapp_queue';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'destination', 'message', 'provider', 'status', 'attempts',
        'scheduled_at', 'sent_at', 'last_error'
    ];

    /**
     * Enqueue a WhatsApp message
     */
    public function enqueue(string $destination, string $message, ?string $scheduledAt = null, string $provider = 'Waha'): bool
    {
        $data = [
            'destination' => $destination,
            'message' => $message,
            'provider' => $provider,
            'status' => 'pending',
            'attempts' => 0,
            'scheduled_at' => $scheduledAt ?? date('Y-m-d H:i:s'),
        ];
        return (bool) $this->insert($data);
    }

    /**
     * Fetch the next pending message (scheduled and not processed)
     */
    public function fetchNext(): ?array
    {
        return $this->where('status', 'pending')
            ->where('scheduled_at <=', date('Y-m-d H:i:s'))
            ->orderBy('scheduled_at', 'ASC')
            ->orderBy('id', 'ASC')
            ->first();
    }

    public function markProcessing(int $id): bool
    {
        return (bool) $this->update($id, [
            'status' => 'processing',
        ]);
    }

    public function markSent(int $id): bool
    {
        return (bool) $this->update($id, [
            'status' => 'sent',
            'sent_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function markFailed(int $id, string $error): bool
    {
        $item = $this->find($id);
        $attempts = isset($item['attempts']) ? (int) $item['attempts'] + 1 : 1;
        return (bool) $this->update($id, [
            'status' => 'failed',
            'attempts' => $attempts,
            'last_error' => $error,
        ]);
    }
}