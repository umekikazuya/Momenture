<?php

namespace App\Services\Contracts;

/**
 * Interface for fetching feed data over HTTP.
 *
 * This interface defines the method necessary for fetching raw feed data
 * from a specified URL. It abstracts the functionality of making HTTP
 * requests to retrieve feed data, allowing different implementations to
 * utilize various HTTP clients or methods.
 */
interface FeedFetcherInterface
{
    /**
     * Fetches raw feed data from the specified URL.
     *
     * This method sends an HTTP GET request to the provided URL and retrieves
     * the feed data as a raw string. It is expected to handle HTTP specifics
     * such as dealing with different response codes and managing exceptions
     * related to network issues or invalid responses.
     *
     * @param  string  $url  The URL from which to fetch the feed data.
     * @return string The raw feed data as a string. If the fetch operation fails, it should throw an appropriate exception or return an empty string.
     *
     * @throws \Exception Throws an exception if there is any error during the fetch operation, including but not limited to network errors, invalid URLs, or error response codes from the server.
     */
    public function get(string $url): string;
}
