<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class YouTube extends BaseConfig
{
    public string $apiKey = '';
    public string $channelId = 'UChBvBOlAoq2YFPdHjWnSjNA';
    public int $maxResults = 4;
    public int $cacheTtl = 600; // seconds

    public function __construct()
    {
        parent::__construct();
        // Load from environment if available
        $this->apiKey = env('YOUTUBE_API_KEY', $this->apiKey);
        $this->channelId = env('YOUTUBE_CHANNEL_ID', $this->channelId);
        $this->maxResults = (int) env('YOUTUBE_MAX_RESULTS', (string) $this->maxResults);
        $this->cacheTtl = (int) env('YOUTUBE_CACHE_TTL', (string) $this->cacheTtl);
    }
}