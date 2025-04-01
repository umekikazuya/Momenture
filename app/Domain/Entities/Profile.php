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
        private ?ProfileAddress $address,
        private ?ProfileDisplayName $displayName,
        private ?ProfileShortName $displayShortName,
        private ?ProfileFrom $from,
        private ?ProfileGithub $github,
        private ?ProfileIntroduction $introduction,
        private ?ProfileJob $job,
        private ?Likes $likes,
        private ?ProfileQiita $qiita,
        private ?Skills $skill,
        private ?ProfileSummaryIntroduction $summaryIntroduction,
        private ?ProfileZenn $zenn,
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
     *
     * @return ProfileAddress|null Addressを表すオブジェクト。存在しない場合はnull。
     */
    public function address(): ?ProfileAddress
    {
        return $this->address;
    }
    /**
     * Profileの表示名を取得。
     *
     * @return ProfileDisplayName|null 表示名を表すオブジェクト。存在しない場合はnull。
     */
    public function displayName(): ?ProfileDisplayName
    {
        return $this->displayName;
    }
    /**
     * Profileの短縮名を取得。
     *
     * @return ProfileShortName|null 短縮名を表すオブジェクト。存在しない場合はnull。
     */

    public function displayShortName(): ?ProfileShortName
    {
        return $this->displayShortName;
    }
    /**
     * Profileの出身地を取得。
     *
     * @return ProfileFrom|null 出身地を表すオブジェクト。存在しない場合はnull。
     */
    public function from(): ?ProfileFrom
    {
        return $this->from;
    }
    /**
     * ProfileのGitHubアカウントを取得。
     *
     * @return ProfileGithub|null GitHubアカウントを表すオブジェクト。存在しない場合はnull。
     */
    public function github(): ?ProfileGithub
    {
        return $this->github;
    }
    /**
     * Profileの自己紹介を取得。
     *
     * @return ProfileIntroduction|null 自己紹介を表すオブジェクト。存在しない場合はnull。
     */
    public function introduction(): ?ProfileIntroduction
    {
        return $this->introduction;
    }
    /**
     * Profileの職業を取得。
     *
     * @return ProfileJob|null 職業を表すオブジェクト。存在しない場合はnull。
     */
    public function job(): ?ProfileJob
    {
        return $this->job;
    }
    /**
     * ProfileのLikesを取得。
     *
     * @return Likes|null Likesを表すオブジェクト。存在しない場合はnull。
     */
    public function likes(): ?Likes
    {
        return $this->likes;
    }
    /**
     * ProfileのQiitaアカウントを取得。
     *
     * @return ProfileQiita|null Qiitaアカウントを表すオブジェクト。存在しない場合はnull。
     */
    public function qiita(): ?ProfileQiita
    {
        return $this->qiita;
    }
    /**
     * Profileのスキルを取得。
     *
     * @return Skills|null スキルを表すオブジェクト。存在しない場合はnull。
     */
    public function skills(): ?Skills
    {
        return $this->skill;
    }
    /**
     * Profileの要約紹介を取得。
     *
     * @return ProfileSummaryIntroduction|null 要約紹介を表すオブジェクト。存在しない場合はnull。
     */
    public function summaryIntroduction(): ?ProfileSummaryIntroduction
    {
        return $this->summaryIntroduction;
    }
    /**
     * ProfileのZennアカウントを取得。
     *
     * @return ProfileZenn|null Zennアカウントを表すオブジェクト。存在しない場合はnull。
     */
    public function zenn(): ?ProfileZenn
    {
        return $this->zenn;
    }

    /**
     * Addressesのセット.
     */
    public function setAddress(?ProfileAddress $address): void
    {
        $this->address = $address;
    }
    /**
     * DisplayNameのセット.
     */
    public function setDisplayName(?ProfileDisplayName $displayName): void
    {
        $this->displayName = $displayName;
    }
    /**
     * DisplayShortNameのセット.
     */
    public function setDisplayShortName(?ProfileShortName $displayShortName): void
    {
        $this->displayShortName = $displayShortName;
    }
    /**
     * Fromのセット.
     */
    public function setFrom(?ProfileFrom $from): void
    {
        $this->from = $from;
    }
    /**
     * Githubのセット.
     */
    public function setGithub(?ProfileGithub $github): void
    {
        $this->github = $github;
    }
    /**
     * Introductionのセット.
     */
    public function setIntroduction(?ProfileIntroduction $introduction): void
    {
        $this->introduction = $introduction;
    }
    /**
     * Jobのセット.
     */
    public function setJob(?ProfileJob $job): void
    {
        $this->job = $job;
    }
    /**
     * Likesのセット.
     */
    public function setLikes(?Likes $likes): void
    {
        $this->likes = $likes;
    }
    /**
     * Qiitaのセット.
     */
    public function setQiita(?ProfileQiita $qiita): void
    {
        $this->qiita = $qiita;
    }
    /**
     * Skillsのセット.
     */
    public function setSkills(?Skills $skills): void
    {
        $this->skill = $skills;
    }
    /**
     * SummaryIntroductionのセット.
     */
    public function setSummaryIntroduction(?ProfileSummaryIntroduction $summaryIntroduction): void
    {
        $this->summaryIntroduction = $summaryIntroduction;
    }
    /**
     * Zennのセット.
     */
    public function setZenn(?ProfileZenn $zenn): void
    {
        $this->zenn = $zenn;
    }

}
