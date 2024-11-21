<?php

namespace App\Services\Contracts;

/**
 * Interface that provide to parse feed data.
 */
interface FeedParserInterface
{
    /**
     * Loads and parses raw feed data into a SimpleXMLElement.
     *
     * This method takes a raw XML string and converts it into a SimpleXMLElement.
     * If the XML string is malformed or empty, the method should return false.
     *
     * @param  string  $feed
     *                        The raw feed data as a string.
     * @return \SimpleXMLElement|false The SimpleXMLElement object if the XML is well-formed and valid, or false if the XML is invalid or cannot be parsed.
     */
    public function loadRawFeedData(string $feed): \SimpleXMLElement|false;

    /**
     * Parse an XML feed into a structured array.
     *
     * @param  \SimpleXMLElement  $xml
     *                                  The XML data to parse, typically retrieved from a feed source.
     * @return array An associative array containing the parsed data.
     */
    public function parseXml(\SimpleXMLElement $xml): array;
}
