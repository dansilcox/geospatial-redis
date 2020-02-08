<?php

declare(strict_types=1);

namespace App\Factory\Service;

use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Service\Repository as RepositoryService;
use App\Service\Cache as CacheService;
use App\Service\Database as DatabaseService;

class Repository
{
    public function __invoke(ContainerInterface $container): RepositoryService
    {
        return new RepositoryService(
            $container->get(CacheService::class),
            $container->get(DatabaseService::class)
        );
    }
}
