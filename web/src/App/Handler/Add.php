<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use App\Service\Repository;
use App\Model\Resource;
use Exception;

class Add implements RequestHandlerInterface
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $decoded = json_decode((string) $request->getBody(), true);
        $name = $decoded['name'] ?? '';
        $id = $decoded['id'] ?? '';
        $latitude = $decoded['latitude'] ?? null;
        $longitude = $decoded['longitude'] ?? null;
        if ($name === '' || $latitude === null || $longitude === null) {
            throw new Exception('Invalid parameter');
        }
        if ($id === '') {
            $model = new Resource();
        } else {
            $model = $this->repository->get($id) ?? new Resource($id);
        }
        $model->name = $name;
        $model->latitude = $latitude;
        $model->longitude = $longitude;

        if (!$this->repository->set($model)) {
            throw new Exception('Failed to save model');
        }

        return new JsonResponse($model, 201);
    }
}
