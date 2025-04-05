<?php

declare(strict_types=1);

namespace App\Application\DTOs;

final class ProfileDto
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $address,
        public readonly ?string $displayName,
        public readonly ?string $displayShortName,
        public readonly ?string $from,
        public readonly ?string $github,
        public readonly ?string $introduction,
        public readonly ?string $job,
        public readonly array $likes,
        public readonly ?string $qiita,
        public readonly array $skills,
        public readonly ?string $summaryIntroduction,
        public readonly ?string $zenn,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address ?? '',
            'display_name' => $this->displayName ?? '',
            'display_short_name' => $this->displayShortName ?? '',
            'from' => $this->from ?? '',
            'github' => $this->github ?? '',
            'introduction' => $this->introduction ?? '',
            'job' => $this->job ?? '',
            'likes' => $this->likes,
            'qiita' => $this->qiita ?? '',
            'skills' => $this->skills,
            'summary_introduction' => $this->summaryIntroduction ?? '',
            'zenn' => $this->zenn ?? '',
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 1),
            address: $data['address'] ?? '',
            displayName: $data['display_name'] ?? '',
            displayShortName: $data['display_short_name'] ?? '',
            from: $data['from'] ?? '',
            github: $data['github'] ?? '',
            introduction: $data['introduction'] ?? '',
            job: $data['job'] ?? '',
            likes: $data['likes'] ?? [],
            qiita: $data['qiita'] ?? '',
            skills: $data['skills'] ?? [],
            summaryIntroduction: $data['summary_introduction'] ?? '',
            zenn: $data['zenn'] ?? '',
        );
    }
}
