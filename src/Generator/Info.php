<?php

namespace JoBins\APIGenerator\Generator;

use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;

class Info extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        public string $version,
    ) {}

    public static function fromJson(array $info): static
    {
        return new static(
            title: Arr::get($info, 'title'),
            description: Arr::get($info, 'description'),
            version: Arr::get($info, 'version'),
        );
    }

    public function toJsonFormat(): array
    {
        return $this->toArray();
    }
}
