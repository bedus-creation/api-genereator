<?php

namespace JoBins\APIGenerator\Generator\Path;

class RequestContent
{
    public function __construct(
        public string $type,
        public string $ref,
    ) {}

    public function toJsonFormat(): array
    {
        return [
            $this->type => [
                'schema' => [
                    'refs' => $this->ref,
                ]
            ]
        ];
    }
}
