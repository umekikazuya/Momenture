<?php

namespace App\Models;

class Profile
{
    public string $id;

    public ?string $displayName;

    public ?string $introduction;

    public array $likes;

    public string $updatedAt;

    public function __construct(array $attributes = [])
    {
        $this->id = $attributes['id'] ?? 'PROFILE#1';
        $this->displayName = $attributes['displayName'] ?? 'Default Name';
        $this->introduction = $attributes['introduction'] ?? 'Default Introduction';
        $this->likes = $attributes['likes'] ?? [];
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
    }
}
