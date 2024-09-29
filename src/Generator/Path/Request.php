<?php

namespace JoBins\APIGenerator\Generator\Path;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Request
{
    public function __construct(
        public ?string $description,

        /** @var Collection<RequestContent> $content */
        public Collection $content,
    ) {}

    public static function fromJson(array $json): Request
    {
        $content = Arr::get($json, 'content') ?? [];
        $content = collect($content)->map(fn($item, $key) => new RequestContent(
            type: $key,
            ref: Arr::get($item, 'schema.$ref') ?? '',
        ))->values();

        return new Request(
            description: $json['description'] ?? null,
            content: $content,
        );
    }

    public function toJsonFormat(): array
    {
        return [
            'content' => $this->content->mapWithKeys(function (RequestContent $content) {
                return $content->toJsonFormat();
            })->toArray(),

            'description' => $this->description,
        ];
    }
}
