<?php

namespace App\Http\Controllers;

use App\Services\Contracts\FeedFetcherInterface;
use App\Services\FeedZennParserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FeedZennController extends Controller
{
    private const ENDPOINT = 'https://zenn.dev/';

    /**
     * Constructor.
     */
    public function __construct(
        private FeedFetcherInterface $feedFetcher,
        private FeedZennParserService $feedParser,
    ) {
        $this->feedFetcher = $feedFetcher;
        $this->feedParser = $feedParser;
    }

    /**
     * Res.
     */
    public function __invoke(string $id): JsonResponse
    {
        try {
            $feed = $this->feedFetcher->get(self::ENDPOINT . $id . '/feed');
            $data = $this->feedParser->loadRawFeedData($feed);
            if (! $data) {
                throw new HttpException('Invalid XML data');
            }
            $data = $this->feedParser->parseXml($data);
        } catch (HttpException $e) {
            throw new HttpException(404, 'Feed not found');
        } catch (\Exception $e) {
            throw new HttpException(422, $e->getMessage());
        }

        return new JsonResponse($data);
    }
}
