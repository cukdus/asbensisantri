<?php

namespace App\Libraries;

use Config\YouTube;

class YouTubeService
{
    protected YouTube $config;

    public function __construct(?YouTube $config = null)
    {
        $this->config = $config ?? config('YouTube');
    }

    /**
     * Get latest videos from YouTube channel via RSS feed (no API key).
     * Returns an array of [videoId, title, publishedAt, thumbnail, url, channelTitle].
     */
    public function getLatestVideos(): array
    {
        $channelId = trim($this->config->channelId ?? '');
        $maxResults = $this->config->maxResults ?? 4;
        $ttl = $this->config->cacheTtl ?? 600;

        if ($channelId === '') {
            return [];
        }

        $cacheKey = sprintf('youtube_latest_%s_%d_rss', $channelId, $maxResults);
        $cache = \Config\Services::cache();
        $cached = $cache->get($cacheKey);
        if (is_array($cached)) {
            return $cached;
        }

        $feedUrl = 'https://www.youtube.com/feeds/videos.xml?channel_id=' . urlencode($channelId);

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->get($feedUrl, [
                'timeout' => 8,
                'followLocation' => true,
                'ssl_verifypeer' => false, // workaround for Windows CA issues
                'ssl_verifyhost' => 0,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) CI4 RSS Fetch',
                    'Accept' => 'application/xml,text/xml;q=0.9,*/*;q=0.8',
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                // Fallback to file_get_contents
                $ctx = stream_context_create([
                    'http' => [
                        'timeout' => 8,
                        'header' => "User-Agent: Mozilla/5.0\r\nAccept: application/xml",
                        'ignore_errors' => true,
                    ],
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ]);
                $body = @file_get_contents($feedUrl, false, $ctx);
                if ($body === false) {
                    log_message('error', 'YouTube RSS fetch failed: HTTP ' . $response->getStatusCode());
                    return [];
                }
            } else {
                $body = (string) $response->getBody();
            }
            $xml = @simplexml_load_string($body);
            if ($xml === false) {
                log_message('error', 'YouTube RSS parse error: unable to load XML');
                return [];
            }

            $ns = $xml->getNamespaces(true);
            $videos = [];

            // Get channel title from feed-level author
            $channelTitle = '';
            if (isset($xml->author->name)) {
                $channelTitle = (string) $xml->author->name;
            }

            foreach ($xml->entry as $entry) {
                $yt = $entry->children($ns['yt'] ?? null);
                $videoId = isset($yt->videoId) ? (string) $yt->videoId : '';
                if ($videoId === '') {
                    continue;
                }

                $title = (string) ($entry->title ?? 'Video');
                $publishedAt = (string) ($entry->published ?? date('c'));

                // Try to get thumbnail from media:group/media:thumbnail
                $thumb = '';
                $media = $entry->children($ns['media'] ?? null);
                if ($media && isset($media->group)) {
                    $group = $media->group;
                    if (isset($group->thumbnail)) {
                        // Prefer the last thumbnail (often highest resolution)
                        foreach ($group->thumbnail as $tn) {
                            $attrs = $tn->attributes();
                            if (isset($attrs['url'])) {
                                $thumb = (string) $attrs['url'];
                            }
                        }
                    }
                }

                // Fallback to standard thumbnail URL pattern
                if ($thumb === '') {
                    $thumb = 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg';
                }

                // If entry-level author exists, use it
                $entryChannelTitle = '';
                if (isset($entry->author->name)) {
                    $entryChannelTitle = (string) $entry->author->name;
                }

                $videos[] = [
                    'videoId' => $videoId,
                    'title' => $title,
                    'publishedAt' => $publishedAt,
                    'thumbnail' => $thumb,
                    'url' => 'https://www.youtube.com/watch?v=' . $videoId,
                    'channelTitle' => $entryChannelTitle !== '' ? $entryChannelTitle : $channelTitle,
                ];

                if (count($videos) >= $maxResults) {
                    break;
                }
            }

            if (!empty($videos)) {
                $cache->save($cacheKey, $videos, $ttl);
            }

            return $videos;
        } catch (\Throwable $e) {
            log_message('error', 'YouTube RSS unexpected error: ' . $e->getMessage());
            return [];
        }
    }
}