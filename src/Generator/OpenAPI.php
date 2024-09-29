<?php

namespace JoBins\APIGenerator\Generator;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use JoBins\APIGenerator\Generator\Path\EndPoint;
use JoBins\APIGenerator\Generator\Path\PathFactory;

class OpenAPI
{
    public function __construct(
        public ?Info $info,
        public Collection $servers,
        public PathFactory $pathFactory,
        public Component $component,
        public Collection $tags,
        public string $openapi = '3.1.0',
    ) {}

    public static function init(): static
    {
        $api  = file_get_contents(base_path('src/Domain/api.json'));
        $JSON = json_decode($api, true);

        return OpenAPI::fromJson($JSON);
    }

    public function addEndpoint(EndPoint $endpoint): static
    {
        $this->pathFactory->add($endpoint);
        $this->store();

        return $this;
    }

    public static function fromJson(array $json): static
    {
        if ($info = Arr::get($json, 'info')) {
            $info = Info::fromJson($info);
        }

        $servers = Arr::get($json, 'servers') ?? [];
        $servers = collect($servers)->map(function ($server) {
            return Server::fromJson($server);
        });

        $paths = Arr::get($json, 'paths');
        $paths = PathFactory::fromJson($paths);

        if ($components = Arr::get($json, 'components')) {
            $components = Component::fromJson($components);
        }

        $tags = Arr::get($json, 'tags');
        $tags = collect($tags)->map(function ($tag) {
            return Tag::fromJson($tag);
        });

        return new OpenAPI(
            info: $info,
            servers: $servers,
            pathFactory: $paths,
            component: $components,
            tags: $tags,
        );
    }

    public function toJsonFormat(): array
    {
        return [
            'openapi'    => $this->openapi,
            'info'       => $this->info->toJsonFormat(),
            'servers'    => $this->servers->map->toJsonFormat()->toArray(),
            'tags'       => $this->tags->map->toJsonFormat()->toArray(),
            'components' => $this->component->toJsonFormat(),
            'paths'      => $this->pathFactory->toJsonFormat(),
        ];
    }

    public function store(): void
    {
        $path = base_path('api.json');
        $data = $this->toJsonFormat();

        File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
