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

    /**
     * Convert the object to an array.
     *
     * @return array{
     *     id: int,
     *     address: string|null,
     *     display_name: string|null,
     *     display_short_name: string|null,
     *     from: string|null,
     *     github: string|null,
     *     introduction: string|null,
     *     job: string|null,
     *     likes: array<string>,
     *     qiita: string|null,
     *     skills: array<string>,
     *     summary_introduction: string|null,
     *     zenn: string|null
     * }
     */
    public function toArray(): array
    {
        return \get_object_vars($this);
    }

    /**
     * Create a new instance from an array.
     *
     * @param array{
     *     id?: int,
     *     address?: string,
     *     display_name?: string,
     *     display_short_name?: string,
     *     from?: string,
     *     github?: string,
     *     introduction?: string,
     *     job?: string,
     *     likes?: array<string>,
     *     qiita?: string,
     *     skills?: array<string>,
     *     summary_introduction?: string,
     *     zenn?: string
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 1),
            address: $data['address'] ?? null,
            displayName: $data['display_name'] ?? null,
            displayShortName: $data['display_short_name'] ?? null,
            from: $data['from'] ?? null,
            github: $data['github'] ?? null,
            introduction: $data['introduction'] ?? null,
            job: $data['job'] ?? null,
            likes: $data['likes'] ?? [],
            qiita: $data['qiita'] ?? null,
            skills: $data['skills'] ?? [],
            summaryIntroduction: $data['summary_introduction'] ?? null,
            zenn: $data['zenn'] ?? null,
        );
    }
}
