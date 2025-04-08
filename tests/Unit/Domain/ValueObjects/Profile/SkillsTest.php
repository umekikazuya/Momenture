<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObjects\Profile;

use App\Domain\ValueObjects\Profile\Skill;
use App\Domain\ValueObjects\Profile\Skills;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SkillsTest extends TestCase
{
    #[Test]
    public function 正しいスキル配列でインスタンス化できること(): void
    {
        $skillObjects = [
            new Skill('PHP'),
            new Skill('Laravel'),
            new Skill('AWS')
        ];

        $skills = new Skills($skillObjects);

        $this->assertSame($skillObjects, $skills->all());
        $this->assertCount(3, $skills->all());
    }

    #[Test]
    public function 特定のスキルが含まれているか確認できること(): void
    {
        $skillObjects = [
            new Skill('PHP'),
            new Skill('Laravel'),
            new Skill('AWS')
        ];

        $skills = new Skills($skillObjects);

        $this->assertTrue($skills->contains(new Skill('PHP')));
        $this->assertTrue($skills->contains(new Skill('Laravel')));
        $this->assertFalse($skills->contains(new Skill('Python')));
    }

    #[Test]
    public function 空の配列の場合はisEmptyがtrueを返すこと(): void
    {
        $skills = new Skills([]);

        $this->assertTrue($skills->isEmpty());
    }

    #[Test]
    public function 配列に変換できること(): void
    {
        $skillObjects = [
            new Skill('PHP'),
            new Skill('Laravel'),
            new Skill('AWS')
        ];

        $skills = new Skills($skillObjects);
        $expectedArray = ['PHP', 'Laravel', 'AWS'];

        $this->assertEquals($expectedArray, $skills->toArray());
    }

    #[Test]
    public function スキル以外のオブジェクトが含まれる場合は例外がスローされること(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Skills に渡す配列は Skill のみを含めてください。');

        new Skills(
            [
            new Skill('PHP'),
            'Laravel', // 文字列
            ]
        );
    }
}
