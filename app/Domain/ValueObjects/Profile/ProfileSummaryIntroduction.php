<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileSummaryIntroduction
{
    /**
     * ProfileSummaryIntroduction クラスのインスタンスを初期化。
     *
     * @param string $summaryIntroduction 文字列
     */
    public function __construct(private readonly string $summaryIntroduction)
    {
        if (mb_strlen($summaryIntroduction) > 1000) {
            throw new \DomainException('概要(詳細)は1000文字以内で指定してください。');
        }
    }

    /**
     * 格納された概要(詳細)を取得。
     *
     * コンストラクタで設定された、有効な概要(詳細)の文字列を返す。
     *
     * @return string 保持されている概要(詳細)文字列
     */
    public function value(): string
    {
        return $this->summaryIntroduction;
    }
}
