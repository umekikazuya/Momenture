<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\FeedParserInterface;

/**
 * Abstract base class for feed parser services.
 *
 * Provides a common foundation for all feed parser implementations.
 * Defines structure and method that all derived classes must implement.
 * Ensures adherence to the FeedParserInterface with implementation of
 * the parseXml method.
 */
abstract class FeedParserServiceBase implements FeedParserInterface
{
    /**
     * {@inheritDoc}
     */
    public function loadRawFeedData(string $feed): \SimpleXMLElement|false
    {
        $data = simplexml_load_string($feed);

        return assert($data instanceof \SimpleXMLElement)
        ? $data
        : false;
    }

    /**
     * {@inheritDoc}
     */
    abstract public function parseXml(\SimpleXMLElement $xml): array;

    /**
     * Get articles.
     *
     * @param \SimpleXMLElement $items
     *
     * @return \Generator
     */
    abstract protected function getArticles(\SimpleXMLElement $items): \Generator;
}
