<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObjects\Profile;

use App\Domain\ValueObjects\Profile\ProfileDisplayName;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProfileDisplayNameTest extends TestCase
{
    #[Test]
    public function 有効な表示名でインスタンス化できること(): void
    {
        $name = '山田太郎';
        $displayName = new ProfileDisplayName($name);

        $this->assertSame($name, $displayName->value());
    }

    #[Test]
    public function 空文字列の場合は例外がスローされること(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('DisplayNameは空にできません。');

        new ProfileDisplayName('');
    }

    #[Test]
    public function 空白のみの場合は例外がスローされること(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('DisplayNameは空にできません。');

        new ProfileDisplayName('   ');
    }

    #[Test]
    public function 最大文字数を超える場合は例外がスローされること(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('DisplayNameは50文字以内で指定してください。');

        $tooLongName = str_repeat('あ', 51);
        new ProfileDisplayName($tooLongName);
    }
}
