<?php

declare(strict_types=1);

namespace App;

use App\Handler\Add as AddHandler;
use App\Handler\GetAll as GetAllHandler;
use App\Handler\Ping as PingHandler;
use App\Factory\Handler\GetAll as GetAllHandlerFactory;
use App\Factory\Handler\Add as AddHandlerFactory;
use App\Service\Cache as CacheService;
use App\Factory\Service\Cache as CacheServiceFactory;
use App\Service\Repository as RepositoryService;
use App\Factory\Service\Repository as RepositoryServiceFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
                PingHandler::class => PingHandler::class,
            ],
            'factories'  => [
                AddHandler::class         => AddHandlerFactory::class,
                GetAllHandler::class      => GetAllHandlerFactory::class,

                CacheService::class       => CacheServiceFactory::class,
                RepositoryService::class  => RepositoryServiceFactory::class
            ],
        ];
    }
}
