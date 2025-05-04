<?php

namespace JoBins\APIGenerator\Generator\Path;

use Illuminate\Support\Collection;

class PathFactory
{
    public function __construct(
        public Collection $paths
    ) {}

    public static function fromJson(array $json): static
    {
        $paths = collect($json)
            ->mapWithKeys(function ($path, $url) {
                return collect($path)->mapWithKeys(function ($path, $method) use ($url) {
                    $path['method'] = $method;
                    $path['url'] = $url;

                    return [$url.'-'.$method => EndPoint::fromJson($path)];
                });
            });

        return new PathFactory(paths: $paths);
    }

    public function toJsonFormat(): array
    {
        return $this->paths
            ->groupBy(function (EndPoint $item) {
                return $item->url;
            })->map(function (Collection $item) {
                return $item->keyBy('method');
            })->map(function (Collection $item) {
                return $item->map->toJsonFormat();
            })->toArray();
    }

    public function add(EndPoint $endpoint): void
    {
        $this->paths->push($endpoint);
    }
}
