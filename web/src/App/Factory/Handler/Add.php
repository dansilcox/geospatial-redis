<?php

declare(strict_types=1);

namespace App\Factory\Handler;

use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Handler\Add as AddHandler;
use App\Service\Repository as RepositoryService;

class Add
{
    public function __invoke(ContainerInterface $container): AddHandler
    {
        return new AddHandler($container->get(RepositoryService::class));
    }
}
