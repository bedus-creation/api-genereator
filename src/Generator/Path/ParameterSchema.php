<?php

namespace JoBins\APIGenerator\Generator\Path;

class ParameterSchema
{
    public function __construct(
        public string $type,
        public ?string $format,
    ) {}

    public function toJsonFormat(): array
    {
        return array_filter([
            'type'   => $this->type,
            'format' => $this->format,
        ]);
    }
}
