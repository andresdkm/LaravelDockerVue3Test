<?php

namespace Modules\Football;

use App\Util\RedisCache;
use Modules\Football\Core\FootballClient\FootballClientFactory;
use Modules\Football\Core\FootballClient\IFootballClient;
use Modules\Football\Services\CompetitionService;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->singleton(IFootballClient::class, function ($app) {
            return FootballClientFactory::make(config('FOOTBALL_PROVIDER',''));
        });
        $this->app->singleton(CompetitionService::class, function ($app) {
            return new CompetitionService($app->make(IFootballClient::class), $app->make(RedisCache::class));
        });
    }

    public static function getName()
    {
        return 'football';
    }


}
