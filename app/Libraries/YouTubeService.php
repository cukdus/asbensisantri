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

    public function getLatestVideos(): array
    {
        $channelId = trim($this->config->channelId ?? '');
        $channelHandle = trim($this->config->channelHandle ?? '');
        $maxResults = $this->config->maxResults ?? 4;
        $ttl = $this->config->cacheTtl ?? 600;

        if ($channelId === '') {
            return [];
        }

        // Prefer fetching from handle page first
        if ($channelHandle !== '') {
            $handleCacheKey = sprintf('youtube_latest_handle_%s_%d_html', $channelHandle, $maxResults);
            $cache = \Config\Services::cache();
            $cachedHandle = $cache->get($handleCacheKey);
            if (is_array($cachedHandle)) {
                return $cachedHandle;
            }
            $videosFromHandle = $this->getLatestFromHandlePage($channelHandle, $maxResults);
            if (!empty($videosFromHandle)) {
                $cache->save($handleCacheKey, $videosFromHandle, $ttl);
                return $videosFromHandle;
            }
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
                'ssl_verifypeer' => false,  // workaround for Windows CA issues
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

    /**
     * Fetch latest videos by scraping YouTube channel handle page (@handle/videos)
     * Note: This is a best-effort fallback and may break if YouTube changes markup.
     */
    private function getLatestFromHandlePage(string $handle, int $maxResults = 4): array
    {
        $url = 'https://www.youtube.com/@' . ltrim($handle, '@') . '/videos?view=0&sort=dd&live_view=501';

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->get($url, [
                'timeout' => 8,
                'followLocation' => true,
                'ssl_verifypeer' => false,
                'ssl_verifyhost' => 0,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) CI4 HTML Fetch',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                ],
            ]);

            $body = (string) $response->getBody();
            if ($response->getStatusCode() !== 200 || $body === '') {
                // Fallback to file_get_contents
                $ctx = stream_context_create([
                    'http' => [
                        'timeout' => 8,
                        'header' => "User-Agent: Mozilla/5.0\r\nAccept: text/html",
                        'ignore_errors' => true,
                    ],
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ]);
                $body = @file_get_contents($url, false, $ctx);
                if ($body === false || $body === '') {
                    log_message('error', 'YouTube HTML fetch failed for handle: ' . $handle);
                    return [];
                }
            }

            // Extract ytInitialData JSON from the page in a balanced manner
            $json = $this->extractYtInitialDataJson($body);
            if ($json === '') {
                log_message('error', 'YouTube HTML parse error: ytInitialData not found');
                return [];
            }

            $data = json_decode($json, true);
            if (!is_array($data)) {
                log_message('error', 'YouTube HTML parse error: ytInitialData JSON invalid');
                return [];
            }

            // Locate richGridRenderer under Videos tab
            $tabs = $data['contents']['twoColumnBrowseResultsRenderer']['tabs'] ?? [];
            $richGrid = null;
            foreach ($tabs as $tab) {
                $tr = $tab['tabRenderer'] ?? null;
                if ($tr && isset($tr['content']['richGridRenderer'])) {
                    $richGrid = $tr['content']['richGridRenderer'];
                    break;
                }
            }
            if (!$richGrid) {
                log_message('error', 'YouTube HTML parse error: richGridRenderer not found');
                return [];
            }

            $videos = [];
            $channelTitle = '';
            foreach (($richGrid['contents'] ?? []) as $item) {
                $content = $item['richItemRenderer']['content'] ?? null;
                $vr = $content['videoRenderer'] ?? null;
                if (!$vr) {
                    continue;
                }
                $videoId = $vr['videoId'] ?? '';
                if ($videoId === '') {
                    continue;
                }
                $title = $vr['title']['runs'][0]['text'] ?? 'Video';
                $channelTitle = $vr['longBylineText']['runs'][0]['text'] ?? $channelTitle;
                // Get highest-res thumbnail url if available
                $thumb = '';
                $tns = $vr['thumbnail']['thumbnails'] ?? [];
                foreach ($tns as $tn) {
                    $thumb = $tn['url'] ?? $thumb;
                }
                if ($thumb === '') {
                    $thumb = 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg';
                }
                // Approximate publishedAt from publishedTimeText (relative string)
                $publishedText = $vr['publishedTimeText']['simpleText']
                    ?? ($vr['publishedTimeText']['runs'][0]['text'] ?? '');
                $publishedAt = $this->approximatePublishedAt($publishedText);

                $videos[] = [
                    'videoId' => $videoId,
                    'title' => $title,
                    'publishedAt' => $publishedAt,
                    'thumbnail' => $thumb,
                    'url' => 'https://www.youtube.com/watch?v=' . $videoId,
                    'channelTitle' => $channelTitle !== '' ? $channelTitle : $handle,
                ];

                if (count($videos) >= $maxResults) {
                    break;
                }
            }

            return $videos;
        } catch (\Throwable $e) {
            log_message('error', 'YouTube HTML unexpected error: ' . $e->getMessage());
            return [];
        }
    }

    private function extractYtInitialDataJson(string $html): string
    {
        $pos = strpos($html, 'ytInitialData');
        if ($pos === false) {
            return '';
        }
        // Find the first '{' after the marker
        $braceStart = strpos($html, '{', $pos);
        if ($braceStart === false) {
            return '';
        }
        // Balance braces to find the JSON object end
        $depth = 0;
        $len = strlen($html);
        for ($i = $braceStart; $i < $len; $i++) {
            $ch = $html[$i];
            if ($ch === '{') {
                $depth++;
            } elseif ($ch === '}') {
                $depth--;
                if ($depth === 0) {
                    $json = substr($html, $braceStart, $i - $braceStart + 1);
                    return $json;
                }
            }
        }
        return '';
    }

    private function approximatePublishedAt(string $text): string
    {
        $text = trim(strtolower($text));
        if ($text === '') {
            return date('c');
        }
        $now = time();
        $delta = 0;
        // English patterns
        if (preg_match('/(\d+)\s*(year|years)\s*ago/', $text, $m)) {
            $delta = (int) $m[1] * 365 * 24 * 3600;
        } elseif (preg_match('/(\d+)\s*(month|months)\s*ago/', $text, $m)) {
            $delta = (int) $m[1] * 30 * 24 * 3600;
        } elseif (preg_match('/(\d+)\s*(week|weeks)\s*ago/', $text, $m)) {
            $delta = (int) $m[1] * 7 * 24 * 3600;
        } elseif (preg_match('/(\d+)\s*(day|days)\s*ago/', $text, $m)) {
            $delta = (int) $m[1] * 24 * 3600;
        } elseif (preg_match('/(\d+)\s*(hour|hours)\s*ago/', $text, $m)) {
            $delta = (int) $m[1] * 3600;
        } elseif (preg_match('/(\d+)\s*(minute|minutes)\s*ago/', $text, $m)) {
            $delta = (int) $m[1] * 60;
        }
        // Indonesian patterns
        elseif (preg_match('/(\d+)\s*(tahun)\s*(yang\s*lalu)?/', $text, $m)) {
            $delta = (int) $m[1] * 365 * 24 * 3600;
        } elseif (preg_match('/(\d+)\s*(bulan)\s*(yang\s*lalu)?/', $text, $m)) {
            $delta = (int) $m[1] * 30 * 24 * 3600;
        } elseif (preg_match('/(\d+)\s*(minggu)\s*(yang\s*lalu)?/', $text, $m)) {
            $delta = (int) $m[1] * 7 * 24 * 3600;
        } elseif (preg_match('/(\d+)\s*(hari)\s*(yang\s*lalu)?/', $text, $m)) {
            $delta = (int) $m[1] * 24 * 3600;
        } elseif (preg_match('/(\d+)\s*(jam)\s*(yang\s*lalu)?/', $text, $m)) {
            $delta = (int) $m[1] * 3600;
        } elseif (preg_match('/(\d+)\s*(menit)\s*(yang\s*lalu)?/', $text, $m)) {
            $delta = (int) $m[1] * 60;
        }

        if ($delta > 0) {
            return date('c', $now - $delta);
        }
        return date('c');
    }
}
