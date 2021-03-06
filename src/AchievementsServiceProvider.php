<?php

namespace Gstt\Achievements;

use Gstt\Achievements\Console\AchievementMakeCommand;
use Gstt\Achievements\Console\AchievementChainMakeCommand;
use Illuminate\Support\ServiceProvider;

class AchievementsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        if ($this->app->runningInConsole()) {
            $this->commands([AchievementMakeCommand::class, AchievementChainMakeCommand::class]);
        }
        $this->app['Gstt\Achievements\Achievement'] = function ($app) {
            return $app['gstt.achievements.achievement'];
        };
        $this->publishes([
            __DIR__ . '/config/achievements.php' => config_path('achievements.php'),
        ], 'config');
        $this->publishes([
            __DIR__.'/Migrations/0000_00_00_000000_create_achievements_tables.php' => database_path('migrations')
        ], 'migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/achievements.php', 'achievements');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
