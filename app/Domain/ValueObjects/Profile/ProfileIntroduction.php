<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileIntroduction
{
    /**
     * ProfileIntroduction クラスのインスタンスを初期化。
     *
     * @param string $introduction 文字列
     */
    public function __construct(private readonly string $introduction)
    {
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
