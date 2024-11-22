<?php

namespace App\Services\Contracts;

/**
 * フィードデータをHTTP経由で取得するためのインターフェース.
 */
interface FeedFetcherInterface
{
    /**
     * 指定されたURLから生のフィードデータを取得.
     *
     * このメソッドは指定されたURLにHTTP GETリクエストを送信し、
     * フィードデータを文字列として取得.
     * HTTPレスポンスコードやネットワークエラーなどを適切に処理することが期待されます.
     *
     * @param  string  $url  フィードデータを取得するURL
     * @return string フィードデータを文字列として返す.
     *                取得に失敗した場合は、適切な例外をスローするか、
     *                空の文字列を返す.
     *
     * @throws \Exception フィードの取得中にエラーが発生した場合にスロー.
     *                    例として、ネットワークエラー、無効なURL、
     *                    サーバーからのエラーレスポンスコードなど.
     */
    public function get(string $url): string;
}
