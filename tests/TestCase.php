<?php

namespace Yajra\Auditable\Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/App/Migrations');
    }

    protected function getPackageProviders($app): array
    {
        return [
            \Yajra\Auditable\AuditableServiceProvider::class,
        ];
    }
}
