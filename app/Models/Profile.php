<?php

namespace App\Models;

class Profile
{
    public string $id;

    public ?string $displayName;

    public ?string $displayShortName;

    public ?string $address;

    public ?string $from;

    public ?string $github;

    public ?string $introduction;

    public ?string $job;

    public array $likes;

    public ?string $qiita;

    public array $skills;

    public ?string $summaryIntroduction;

    public ?string $zenn;

    public string $updatedAt;

    public function __construct(array $attributes = [])
    {
        $this->id = $attributes['id'] ?? 'PROFILE#1';
        $this->displayName = $attributes['displayName'] ?? null;
        $this->displayShortName = $attributes['displayShortName'] ?? null;
        $this->address = $attributes['address'] ?? null;
        $this->from = $attributes['from'] ?? null;
        $this->github = $attributes['github'] ?? null;
        $this->introduction = $attributes['introduction'] ?? null;
        $this->job = $attributes['job'] ?? null;
        $this->likes = $attributes['likes'] ?? [];
        $this->qiita = $attributes['qiita'] ?? null;
        $this->skills = $attributes['skills'] ?? [];
        $this->summaryIntroduction = $attributes['summaryIntroduction'] ?? null;
        $this->zenn = $attributes['zenn'] ?? null;
        $this->updatedAt = $attributes['updatedAt'] ?? now()->toIso8601String();
    }

    public function update(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        $this->updatedAt = now()->toIso8601String();
    }

    public function validate(): void
    {
        if (strlen($this->displayName) > 255) {
            throw new \InvalidArgumentException('Display name exceeds 255 characters.');
        }

        if ($this->address && strlen($this->address) > 500) {
            throw new \InvalidArgumentException('Address exceeds 500 characters.');
        }

        if ($this->from && strlen($this->from) > 255) {
            throw new \InvalidArgumentException('From field exceeds 255 characters.');
        }

        if (count($this->likes) > 50) {
            throw new \InvalidArgumentException('Too many likes. Maximum is 50.');
        }

        if (count($this->skills) > 50) {
            throw new \InvalidArgumentException('Too many skills. Maximum is 50.');
        }
    }
}
