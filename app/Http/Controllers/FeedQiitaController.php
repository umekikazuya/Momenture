<?php

namespace App\Http\Controllers;

use App\Services\Contracts\FeedFetcherInterface;
use App\Services\Contracts\FeedParserInterface;
use Illuminate\Http\JsonResponse;

class FeedQiitaController extends Controller
{
    private const ENDPOINT = 'https://qiita.com/';

    /**
     * Constructor.
     */
    public function __construct(
        private FeedFetcherInterface $feedFetcher,
        private FeedParserInterface $feedParser,
    ) {
        $this->feedFetcher = $feedFetcher;
        $this->feedParser = $feedParser;
    }

    /**
     * Res.
     */
    public function __invoke(string $id)
    {
        try {
            // Get request.
            $feed = $this->feedFetcher->get(self::ENDPOINT . $id . '/feed');
            // Load and parse xml data.
            $data = $this->feedParser->loadRawFeedData($feed);
            if (! $data) {
                throw new \Exception;
            }
            $data = $this->feedParser->parseXml($data);

        } catch (\Exception $e) {
            return new JsonResponse([], 403);
        }

        return new JsonResponse($data);
    }
}
