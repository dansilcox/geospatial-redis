<?php

declare(strict_types=1);

namespace App\Factory\Service;

use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Service\Database as DatabaseService;

class Database
{
    public function __invoke(ContainerInterface $container): DatabaseService
    {
        return new DatabaseService('pdo_mysql', 'db', 'root', 'example', 3306, 'geotest');
    }
}
