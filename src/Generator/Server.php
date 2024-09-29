<?php

namespace JoBins\APIGenerator\Generator;

use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;

class Server extends Data
{
    public function __construct(
        public string $url,
    ) {}

    public static function fromJson($server): Server
    {
        return new self(
            url: Arr::get($server, 'url'),
        );
    }

    public function toJsonFormat(): array
    {
        return $this->toArray();
    }
}
