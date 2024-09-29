<?php

namespace JoBins\APIGenerator\Generator\Path;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Response
{
    public function __construct(
        public string $statusCode,
        public ?string $description,

        /** @var Collection<RequestContent> $content */
        public Collection $content,
    ) {}

    public function toJsonFormat(): array
    {
        return array_filter([
            'description' => $this->description,
            'content'     => $this->content->mapWithKeys(function (RequestContent $content) {
                return $content->toJsonFormat();
            })->toArray(),
        ]);
    }

    public static function fromJson(array $json, string $status): Response
    {
        $content = Arr::get($json, 'content') ?? [];
        $content = collect($content)
            ->map(fn($item, $key) => new RequestContent(
                type: $key,
                ref: Arr::get($item, 'schema.$ref') ?? '',
            ))->values();

        return new Response(
            statusCode: $status,
            description: Arr::get($json, 'description'),
            content: $content,
        );
    }
}
