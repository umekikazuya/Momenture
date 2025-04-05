<?php

namespace App\Domain\Entities;

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
use App\Domain\ValueObjects\Profile\Skills;

class Profile
{
    /**
     * Profileエンティティを初期化。
     */
    public function __construct(
        private ProfileId $id,
        private ProfileAddress $address,
        private ProfileDisplayName $displayName,
        private ProfileShortName $displayShortName,
        private ProfileFrom $from,
        private ProfileGithub $github,
        private ProfileIntroduction $introduction,
        private ProfileJob $job,
        private Likes $likes,
        private ProfileQiita $qiita,
        private Skills $skill,
        private ProfileSummaryIntroduction $summaryIntroduction,
        private ProfileZenn $zenn,
    ) {}

    /**
     * Profileの一意なIDを取得。
     *
     * Profileエンティティに設定された識別子を返す。
     *
     * @return ProfileId ProfileのID
     */
    public function id(): ProfileId
    {
        return $this->id;
    }

    /**
     * ProfileのAddressを取得。
     */
    public function address(): ProfileAddress
    {
        return $this->address;
    }

    /**
     * Profileの表示名を取得。
     */
    public function displayName(): ProfileDisplayName
    {
        return $this->displayName;
    }

    /**
     * Profileの短縮名を取得。
     */
    public function displayShortName(): ProfileShortName
    {
        return $this->displayShortName;
    }

    /**
     * Profileの出身地を取得。
     */
    public function from(): ProfileFrom
    {
        return $this->from;
    }

    /**
     * ProfileのGitHubアカウントを取得。
     */
    public function github(): ProfileGithub
    {
        return $this->github;
    }

    /**
     * Profileの自己紹介を取得。
     */
    public function introduction(): ProfileIntroduction
    {
        return $this->introduction;
    }

    /**
     * Profileの職業を取得。
     */
    public function job(): ProfileJob
    {
        return $this->job;
    }

    /**
     * ProfileのLikesを取得。
     */
    public function likes(): Likes
    {
        return $this->likes;
    }

    /**
     * ProfileのQiitaアカウントを取得。
     */
    public function qiita(): ProfileQiita
    {
        return $this->qiita;
    }

    /**
     * Profileのスキルを取得。
     */
    public function skills(): Skills
    {
        return $this->skill;
    }

    /**
     * Profileの要約紹介を取得。
     */
    public function summaryIntroduction(): ProfileSummaryIntroduction
    {
        return $this->summaryIntroduction;
    }

    /**
     * ProfileのZennアカウントを取得。
     */
    public function zenn(): ProfileZenn
    {
        return $this->zenn;
    }
}
