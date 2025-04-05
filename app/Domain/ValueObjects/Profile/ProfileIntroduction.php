<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileIntroduction
{
    /**
     * ProfileIntroduction クラスのインスタンスを初期化。
     *
     * @param string $introduction 文字列
     *
     * @throws \DomainException 無効な概要が指定された場合
     */
    public function __construct(private readonly string $introduction)
    {
        if (trim($introduction) === '') {
            throw new \DomainException('概要は空にできません。');
        }
    }

    /**
     * 格納された概要を取得。
     *
     * コンストラクタで設定された、有効な概要の文字列を返す。
     *
     * @return string 保持されている概要文字列
     */
    public function value(): string
    {
        return $this->introduction;
    }
}
