<?php

namespace JoBins\APIGenerator\Generator\Path;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class EndPoint extends Data
{
    public function __construct(
        public string $url,
        public string $method,
        public string $operationId,
        public ?array $tags,
        public ?string $summary,
        public ?string $description,

        /** @var Collection<Parameter> */
        public Collection $parameters,

        public ?Request $request,

        public Collection $responses,
    ) {}

    public static function fromRequestResponse($request, $response): self
    {
        dd($request, $response);
    }

    public static function fromJson(array $path): static
    {
        $parameters = Arr::get($path, 'parameters') ?? [];
        $parameters = collect($parameters)->map(function ($parameter) {
            return Parameter::fromJson($parameter);
        });

        $request = null;
        if ($requestBody = Arr::get($path, 'requestBody')) {
            $request = Request::fromJson($requestBody);
        }

        $responses = Arr::get($path, 'responses');
        $responses = collect($responses)->map(function ($response, string $key) {
            return Response::fromJson($response, $key);
        });

        return new EndPoint(
            url: Arr::get($path, 'url'),
            method: Arr::get($path, 'method'),
            operationId: Arr::get($path, 'operationId'),
            summary: Arr::get($path, 'summary'),
            description: Arr::get($path, 'description'),
            tags: Arr::get($path, 'tags'),
            parameters: $parameters,
            request: $request,
            responses: $responses,
        );
    }

    public function toJsonFormat(): array
    {
        return array_filter([
            'tags' => $this->tags,
            'summary' => $this->summary,
            'description' => $this->description,
            'operationId' => $this->operationId,
            'requestBody' => $this->request?->toJsonFormat(),
            'responses' => $this->responses->mapWithKeys(function (Response $response) {
                return [$response->statusCode => $response->toJsonFormat()];
            })->toArray(),
            'parameters' => $this->parameters->map->toJsonFormat()->toArray(),
        ]);
    }
}
