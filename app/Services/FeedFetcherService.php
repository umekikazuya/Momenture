<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\FeedFetcherInterface;
use GuzzleHttp\Client;

/**
 * Service class for fetching feed data using the Guzzle HTTP client.
 *
 * This class implements the FeedFetcherInterface to provide a concrete
 * method for fetching feed data over HTTP. It utilizes the Guzzle HTTP
 * client to send GET requests and handle responses. The class is designed
 * to manage HTTP communication and error handling effectively, encapsulating
 * all the complexities of network interactions.
 */
final class FeedFetcherService implements FeedFetcherInterface
{
    /**
     * Constructor.
     *
     * Initializes the feed fetcher service with a Guzzle HTTP client.
     *
     * @param  \GuzzleHttp\Client  $httpClient  The Guzzle HTTP client instance.
     */
    public function __construct(
        private Client $httpClient,
    ) {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $url): string
    {
        try {
            return $this
                ->httpClient
                ->get($url)
                ->getBody()->getContents();
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }
}
