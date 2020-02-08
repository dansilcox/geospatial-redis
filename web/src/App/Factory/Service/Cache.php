<?php

declare(strict_types=1);

namespace App\Factory\Service;

use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Service\Cache as CacheService;

class Cache
{
    public function __invoke(ContainerInterface $container): CacheService
    {
        return new CacheService('redis');
    }
}
