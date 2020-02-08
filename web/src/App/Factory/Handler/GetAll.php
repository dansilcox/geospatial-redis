<?php

declare(strict_types=1);

namespace App\Factory\Handler;

use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Handler\GetAll as GetAllHandler;
use App\Service\Repository as RepositoryService;

class GetAll
{
    public function __invoke(ContainerInterface $container): GetAllHandler
    {
        return new GetAllHandler($container->get(RepositoryService::class));
    }
}
