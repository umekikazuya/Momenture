<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Carbon;

/**
 * Provides functionality to parse Qiita XML feeds.
 *
 * This service is responsible for parsing XML feed data retrieved from Qiita.
 * It converts the raw XML data into a structured array that can be easily
 * used within Laravel. This class extends the generic FeedParserServiceBase
 * to implement Qiita-specific parsing logic.
 */
final class FeedQiitaParserService extends FeedParserServiceBase
{
    /**
     * {@inheritDoc}
     */
    public function parseXml(\SimpleXMLElement $xml): array
    {
        if (! $xml->entry instanceof \SimpleXMLElement) {
            return [];
        }

        return [
            'title' => (string) $xml->title,
            'link' => (string) current($xml->link[2] ?? []),
            'data' => iterator_to_array($this->getArticles($xml->entry)),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getArticles(\SimpleXMLElement $items): \Generator
    {
        foreach ($items as $o) {
            // Get feed item.
            $title = (string) $o->title;
            $attributes = $o->link->attributes();
            $link = (string) $attributes['href'];
            $published = (string) $o->published;
            if (empty($title) || empty($link) || empty($published)) {
                continue;
            }
            try {
                $published = Carbon::parse($published);
            } catch (\Exception $e) {
                continue;
            }

            yield [
                'title' => $title,
                'link' => $link,
                'published' => $published->format('c'),
            ];
        }
    }
}
