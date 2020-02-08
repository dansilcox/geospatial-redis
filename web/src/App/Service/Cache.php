<?php

declare(strict_types=1);

namespace App\Service;

use Redis;
use App\Model\Resource;

final class Cache
{
    private const GEOUNIT = 'm';
    private Redis $redis;

    public function __construct(string $redisHost)
    {
        $this->redis = new Redis();
        $this->redis->connect($redisHost);

    }

    public function ping(): bool
    {
        return $this->redis->ping();
    }

    public function geoAdd(string $geoKey, Resource ...$resources): int
    {
        $count = 0;
        foreach ($resources as $resource) {
            $count += $this->redis->geoAdd($geoKey, $resource->longitude, $resource->latitude, $resource->getId());
        }
        return $count;
    }

    public function geoRadius(string $key, float $longitude, float $latitude, int $radius)
    {
        $rawItems = $this->redis->geoRadius($key, $longitude, $latitude, $radius, self::GEOUNIT, ['WITHDIST', 'ASC']);
        $return = [];
        foreach ($rawItems as $rawItem) {
            [$rawItemId, $distance] = $rawItem;
            $model = $this->get($rawItemId);
            var_dump($model);exit;
            if ($model === null) {
                continue;
            }
            $model->distance = $distance;
            $return[] = $model;
        }
        return $return;
    }

    public function set(string $key, $value, $ttl = null): bool
    {
        return $this->redis->set($key, $value, $ttl);
    }

    public function get(string $key, $default = null)
    {
        return $this->redis->get($key) ?? $default;
    }

    public function __destruct()
    {
        if ($this->redis) {
            $this->redis->close();
        }
    }
}
