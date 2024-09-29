<?php

namespace JoBins\APIGenerator\Generator\Path;

use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;

class Parameter extends Data
{
    public function __construct(
        public string $name,
        public string $description,
        public ?bool $required,
        public string $in,
        public ParameterSchema $schema,
    ) {
    }

    public static function fromJson(array $json): Parameter
    {
        $schema = Arr::get($json, 'schema') ?? [];
        $schema = new ParameterSchema(
            type: Arr::get($schema, 'type'),
            format: Arr::get($schema, 'format'),
        );

        return new Parameter(
            name: Arr::get($json, 'name'),
            description: Arr::get($json, 'description'),
            required: Arr::get($json, 'required'),
            in: Arr::get($json, 'in'),
            schema: $schema,
        );
    }

    public function toJsonFormat(): array
    {
        return array_filter([
            'name'         => $this->name,
            'description'  => $this->description,
            'required'     => $this->required,
            'in'           => $this->in,
            'schema'       => $this->schema->toJsonFormat(),
        ]);
    }
}
