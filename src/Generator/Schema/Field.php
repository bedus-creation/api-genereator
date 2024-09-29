<?php

namespace JoBins\APIGenerator\Generator\Schema;

use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;

class Field extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $format,
        public ?string $type,
        public bool $required = false,
        public ?array $examples = null
    ) {}

    public static function fromJson(array $field, string $name, bool $required): static
    {
        return Field::from([
            'name'        => $name,
            'description' => Arr::get($field, 'description'),
            'format'      => Arr::get($field, 'format'),
            'type'        => Arr::get($field, 'type'),
            'required'    => $required,
        ]);
    }

    public function toJsonFormat(): array
    {
        return array_filter([
            'type'        => $this->type,
            'format'      => $this->format,
            'description' => $this->description,
        ]);
    }
}
