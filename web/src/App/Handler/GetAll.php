<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use App\Service\Repository;
use Exception;

class GetAll implements RequestHandlerInterface
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $query = $request->getUri()->getQuery();
        $params = [];
        parse_str($query, $params);
        $latitude = filter_var($params['latitude'], FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE) ?? null;
        $longitude = filter_var($params['longitude'], FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE) ?? null;
        $radius = filter_var($params['radius'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) ?? 8000;
        
        if ($latitude === null || $longitude === null) {
            throw new Exception('Missing required field');
        }
        $data = $this->repository->nearbySearch($latitude, $longitude, $radius);
        return new JsonResponse([
            'data' => $data,
            'meta' => [
                'latitude'  => $latitude,
                'longitude' => $longitude,
                'radius'    => $radius
            ]
        ]);
    }
}
