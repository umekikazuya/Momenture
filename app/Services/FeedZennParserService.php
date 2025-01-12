<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Carbon;

/**
 * Provides functionality to parse Zenn XML feeds.
 *
 * This service is responsible for parsing XML feed data retrieved from Zenn.
 * It converts the raw XML data into a structured array that can be easily
 * used within Laravel. This class extends the generic FeedParserServiceBase
 * to implement Zenn-specific parsing logic.
 */
final class FeedZennParserService extends FeedParserServiceBase
{
    /**
     * {@inheritDoc}
     */
    public function parseXml(\SimpleXMLElement $xml): array
    {
        if (! $xml->channel->$xml instanceof \SimpleXMLElement) {
            return [];
        }

        return [
            'title' => (string) $xml->channel->generator,
            'link' => (string) $xml->channel->link,
            'data' => iterator_to_array($this->getArticles($xml->channel->item)),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getArticles(\SimpleXMLElement $items): \Generator
    {
        foreach ($items as $o) {
            $title = (string) $o->title;
            $link = (string) $o->link;
            $published = (string) $o->pubDate;
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
