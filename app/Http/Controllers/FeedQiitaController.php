<?php

namespace App\Http\Controllers;

use App\Services\Contracts\FeedFetcherInterface;
use App\Services\Contracts\FeedParserInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
