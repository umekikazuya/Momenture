<?php

namespace App\Services\Contracts;

/**
 * フィードデータを解析するためのインターフェース。
 */
interface FeedParserInterface
{
    /**
     * 生のフィードデータを読み込み、SimpleXMLElement に変換.
     *
     * このメソッドは、生のXML文字列を受け取り、SimpleXMLElement に変換.
     * XML文字列が不正または空の場合、このメソッドは false を返す.
     *
     * @param string $feed 生のフィードデータを含む文字列
     * @return \SimpleXMLElement|false XMLが正しく形成されていれば SimpleXMLElement オブジェクトを返し、不正または解析できない場合は false を返す.
     */
    public function loadRawFeedData(string $feed): \SimpleXMLElement|false;

    /**
     * XMLフィードを構造化された配列に解析.
     *
     * @param \SimpleXMLElement $xml フィードソースから取得されたXMLデータ
     * @return array 解析されたデータを含む連想配列を返す.
     */
    public function parseXml(\SimpleXMLElement $xml): array;
}
