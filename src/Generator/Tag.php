<?php

namespace JoBins\APIGenerator\Generator;

use Spatie\LaravelData\Data;

class Tag extends Data
{
    public function __construct(
        public string $name,
        public string $description,
    ) {}

    public static function fromJson(array $json): Tag
    {
        return new Tag(
            name: $json['name'],
            description: $json['description'] ?? null,
        );
    }

    public function toJsonFormat(): array
    {
        return $this->toArray();
    }
}
