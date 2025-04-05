<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class ProfileJob
{
    /**
     * 職業を表す文字列を初期化。
     *
     * @param string $job 職業
     *
     * @throws \DomainException 無効な職業が指定された場合
     */
    public function __construct(private readonly string $job)
    {
        if (trim($job) === '') {
            throw new \DomainException('Job は空にできません。');
        }
    }

    /**
     * 格納された職業を取得。
     *
     * コンストラクタで設定された、有効な職業の文字列を返す。
     *
     * @return string 保持されている職業文字列
     */
    public function value(): string
    {
        return $this->job;
    }
}
