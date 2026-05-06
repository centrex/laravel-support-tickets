<?php

declare(strict_types = 1);

namespace Centrex\LivewireSupportTickets\Tests;

use Centrex\LivewireSupportTickets\LivewireSupportTicketsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName): string => 'Centrex\\LivewireSupportTickets\\Database\\Factories\\' . class_basename($modelName) . 'Factory',
        );
    }

    #[\Override]
    protected function getPackageProviders($app)
    {
        return [
            LivewireSupportTicketsServiceProvider::class,
        ];
    }

    #[\Override]
    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_livewire-support-tickets_table.php.stub';
        $migration->up();
        */
    }
}
