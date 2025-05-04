<?php

namespace JoBins\APIGenerator\Generator;

use Illuminate\Support\Arr;
use JoBins\APIGenerator\Generator\Schema\SchemaFactory;

class Component
{
    public function __construct(
        public SchemaFactory $schemas,
    ) {}

    public static function fromJson(array $json): Component
    {
        if ($schemas = Arr::get($json, 'schemas')) {
            $schemas = SchemaFactory::fromJson($schemas);
        }

        return new Component(
            schemas: $schemas
        );
    }

    public function toJsonFormat(): array
    {
        return [
            'schemas' => $this->schemas->toJsonFormat(),
        ];
    }
}
