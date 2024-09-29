<?php

namespace JoBins\APIGenerator\Generator\Schema;

use Illuminate\Support\LazyCollection;

class SchemaFactory
{
    public function __construct(
        public LazyCollection $schemas
    ) {}

    public static function fromJson(array $json): static
    {
        $schemas = LazyCollection::make($json)
            ->map(function (array $schema, string $name) {
                return Schema::fromJson($schema, $name);
            });

        return new SchemaFactory(
            schemas: $schemas
        );
    }

    public function toJsonFormat(): array
    {
        return $this->schemas->map->toJsonFormat()->toArray();
    }
}
