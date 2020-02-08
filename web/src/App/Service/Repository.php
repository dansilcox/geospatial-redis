<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Resource;
use Exception;

final class Repository
{
    private const GEOKEY = 'geo';

    private Cache $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
        if (!$this->cache->ping()) {
          throw new Exception('Unable to connect to cache');
        }
    }

    public function set(Resource $resource): bool
    {
        $this->cache->geoAdd(self::GEOKEY, $resource);
        return $this->cache->set($resource->getId(), json_encode($resource));
    }

    public function get(string $key): Resource
    {
        $object = json_decode($this->cache->get($key));
        $model = new Resource($object->id);
        $model->name = $object->name;
        $model->latitude = $object->latitude;
        $model->longitude = $object->longitude;
        return $model;
    }

    public function nearbySearch(float $latitude, float $longitude, int $radius): array
    {
        var_dump($this->cache->geoRadius(self::GEOKEY, $longitude, $latitude, $radius));
        exit;
    }
}
