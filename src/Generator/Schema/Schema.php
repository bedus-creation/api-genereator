<?php

namespace JoBins\APIGenerator\Generator\Schema;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class Schema extends Data
{
    public function __construct(
        public string $name,

        public string $title,

        public ?string $type,
        /**
         * @var Collection<Field> $fields
         */
        public Collection $fields,

        #[Computed]
        public ?array $required,
    ) {
        $this->required = $this->fields
            ->filter(fn(Field $item) => $item->required)
            ->map(fn(Field $item) => $item->name)
            ->values()
            ->toArray();
    }

    public static function fromJson(array $json, string $name): Schema
    {
        $properties = Arr::get($json, 'properties');
        $type       = Arr::get($json, 'type');
        $required   = Arr::get($json, 'required') ?? [];

        $fields = [];
        foreach ($properties as $fieldName => $property) {
            $isRequired = in_array($fieldName, $required);
            $fields[]   = Field::fromJson($property, $fieldName, $isRequired);
        }

        return Schema::from([
            'name'   => $name,
            'title'  => $name,
            'type'   => $type,
            'fields' => collect($fields),
        ]);
    }

    public function toJsonFormat()
    {
        return array_filter([
            'type'       => 'object',
            'required'   => $this->required,
            'properties' => $this->fields->mapWithKeys(fn(Field $item) => [
                $item->name => $item->toJsonFormat()
            ])->toArray(),
        ]);
    }
}
