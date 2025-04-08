<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObjects\Profile;

use App\Domain\ValueObjects\Profile\Skill;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SkillTest extends TestCase
{
    #[Test]
    public function 有効なスキル名でインスタンス化できること(): void
    {
        $value = 'PHP';
        $skill = new Skill($value);

        $this->assertSame($value, $skill->value());
    }

    #[Test]
    public function 空文字列の場合は例外がスローされること(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Skill は空にできません。');

        new Skill('');
    }

    #[Test]
    public function 空白のみの場合は例外がスローされること(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Skill は空にできません。');

        new Skill('   ');
    }

    #[Test]
    public function 同じ値を持つスキルは等価と判定されること(): void
    {
        $skill1 = new Skill('PHP');
        $skill2 = new Skill('PHP');
        $skill3 = new Skill('Laravel');

        $this->assertTrue($skill1->equals($skill2));
        $this->assertFalse($skill1->equals($skill3));
    }
}
