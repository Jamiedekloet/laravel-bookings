<?php

declare(strict_types=1);

namespace Rinvex\Bookings\Providers;

use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Rinvex\Bookings\Console\Commands\MigrateCommand;
use Rinvex\Bookings\Console\Commands\PublishCommand;
use Rinvex\Bookings\Console\Commands\RollbackCommand;

class BookingsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.rinvex.bookings.migrate',
        PublishCommand::class => 'command.rinvex.bookings.publish',
        RollbackCommand::class => 'command.rinvex.bookings.rollback',
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'rinvex.bookings');
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/rinvex.bookings.php' => config_path('rinvex/laravel-bookings.php'),
        ]);

        $this->publishes([
            __DIR__.'/../../database/migrations/' => database_path('migrations')
        ], 'rinvex/laravel-bookings');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
