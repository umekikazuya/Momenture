<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Profile;
use App\Domain\ValueObjects\Profile\Like;
use App\Domain\ValueObjects\Profile\Likes;
use App\Domain\ValueObjects\Profile\ProfileAddress;
use App\Domain\ValueObjects\Profile\ProfileDisplayName;
use App\Domain\ValueObjects\Profile\ProfileFrom;
use App\Domain\ValueObjects\Profile\ProfileGithub;
use App\Domain\ValueObjects\Profile\ProfileId;
use App\Domain\ValueObjects\Profile\ProfileIntroduction;
use App\Domain\ValueObjects\Profile\ProfileJob;
use App\Domain\ValueObjects\Profile\ProfileQiita;
use App\Domain\ValueObjects\Profile\ProfileShortName;
use App\Domain\ValueObjects\Profile\ProfileSummaryIntroduction;
use App\Domain\ValueObjects\Profile\ProfileZenn;
use App\Domain\ValueObjects\Profile\Skill;
use App\Domain\ValueObjects\Profile\Skills;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    private Profile $profile;
    private ProfileId $id;
    private ProfileDisplayName $displayName;
    private ProfileShortName $shortName;
    private ProfileIntroduction $introduction;
    private ProfileSummaryIntroduction $summaryIntroduction;
    private ProfileJob $job;
    private ProfileFrom $from;
    private ProfileAddress $address;
    private ProfileGithub $github;
    private ProfileQiita $qiita;
    private ProfileZenn $zenn;
    private Skills $skills;
    private Likes $likes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = new ProfileId(1);
        $this->displayName = new ProfileDisplayName('山田太郎');
        $this->shortName = new ProfileShortName('山田');
        $this->introduction = new ProfileIntroduction('自己紹介文です');
        $this->summaryIntroduction = new ProfileSummaryIntroduction('要約文です');
        $this->job = new ProfileJob('エンジニア');
        $this->from = new ProfileFrom('東京');
        $this->address = new ProfileAddress('東京都渋谷区');
        $this->github = new ProfileGithub('yamada-taro');
        $this->qiita = new ProfileQiita('yamada_taro');
        $this->zenn = new ProfileZenn('yamada-taro');
        $this->skills = new Skills(
            [
            new Skill('PHP'),
            new Skill('Laravel'),
            new Skill('AWS')
            ]
        );
        $this->likes = new Likes(
            [
            new Like('映画鑑賞'),
            new Like('読書')
            ]
        );

        $this->profile = new Profile(
            $this->id,
            $this->address,
            $this->displayName,
            $this->shortName,
            $this->from,
            $this->github,
            $this->introduction,
            $this->job,
            $this->likes,
            $this->qiita,
            $this->skills,
            $this->summaryIntroduction,
            $this->zenn
        );
    }

    #[Test]
    public function すべての値が正しく取得できること(): void
    {
        $this->assertSame($this->id, $this->profile->id());
        $this->assertSame($this->displayName, $this->profile->displayName());
        $this->assertSame($this->shortName, $this->profile->displayShortName());
        $this->assertSame($this->introduction, $this->profile->introduction());
        $this->assertSame($this->summaryIntroduction, $this->profile->summaryIntroduction());
        $this->assertSame($this->job, $this->profile->job());
        $this->assertSame($this->from, $this->profile->from());
        $this->assertSame($this->address, $this->profile->address());
        $this->assertSame($this->github, $this->profile->github());
        $this->assertSame($this->qiita, $this->profile->qiita());
        $this->assertSame($this->zenn, $this->profile->zenn());
        $this->assertSame($this->skills, $this->profile->skills());
        $this->assertSame($this->likes, $this->profile->likes());
    }

    #[Test]
    public function スキルの内容が正しく取得できること(): void
    {
        $skills = $this->profile->skills();
        $skillValues = array_map(fn ($skill) => $skill->value(), $skills->all());

        $this->assertContains('PHP', $skillValues);
        $this->assertContains('Laravel', $skillValues);
        $this->assertContains('AWS', $skillValues);
        $this->assertCount(3, $skillValues);
    }

    #[Test]
    public function 好きなものの内容が正しく取得できること(): void
    {
        $likes = $this->profile->likes();
        $likeValues = array_map(fn ($like) => $like->value(), $likes->all());

        $this->assertContains('映画鑑賞', $likeValues);
        $this->assertContains('読書', $likeValues);
        $this->assertCount(2, $likeValues);
    }
}
