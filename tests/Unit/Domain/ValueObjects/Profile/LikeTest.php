<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObjects\Profile;

use App\Domain\ValueObjects\Profile\Like;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LikeTest extends TestCase
{
    #[Test]
    public function 有効な好きなものでインスタンス化できること(): void
    {
        $value = '映画鑑賞';
        $like = new Like($value);

        $this->assertSame($value, $like->value());
    }

    #[Test]
    public function 空文字列の場合は例外がスローされること(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Like は空にできません。');

        new Like('');
    }

    #[Test]
    public function 空白のみの場合は例外がスローされること(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Like は空にできません。');

        new Like('   ');
    }

    #[Test]
    public function 最大文字数を超える場合は例外がスローされること(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Like は50文字以内にしてください。');

        $tooLongValue = str_repeat('あ', 51);
        new Like($tooLongValue);
    }

    #[Test]
    public function 同じ値を持つインスタンスは等価と判定されること(): void
    {
        $like1 = new Like('映画鑑賞');
        $like2 = new Like('映画鑑賞');
        $like3 = new Like('読書');

        $this->assertTrue($like1->equals($like2));
        $this->assertFalse($like1->equals($like3));
    }
}
