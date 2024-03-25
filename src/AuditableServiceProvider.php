<?php

declare(strict_types=1);

namespace Yajra\Auditable;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AuditableServiceProvider extends ServiceProvider
{
    /**
     * Boot the package.
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/auditable.php', 'auditable');
        $this->publishes([
            __DIR__.'/config/auditable.php' => base_path('config/auditable.php'),
        ], 'auditable');
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        Blueprint::macro('auditable', function () {
            /** @var Blueprint $blueprint */
            $blueprint = $this;
            $blueprint->unsignedBigInteger('created_by')->nullable()->index();
            $blueprint->unsignedBigInteger('updated_by')->nullable()->index();
        });

        Blueprint::macro('dropAuditable', function () {
            /** @var Blueprint $blueprint */
            $blueprint = $this;
            $blueprint->dropColumn(['created_by', 'updated_by']);
        });

        Blueprint::macro('auditableWithDeletes', function () {
            /** @var Blueprint $blueprint */
            $blueprint = $this;
            $blueprint->unsignedBigInteger('created_by')->nullable()->index();
            $blueprint->unsignedBigInteger('updated_by')->nullable()->index();
            $blueprint->unsignedBigInteger('deleted_by')->nullable()->index();
        });

        Blueprint::macro('dropAuditableWithDeletes', function () {
            /** @var Blueprint $blueprint */
            $blueprint = $this;
            $blueprint->dropColumn(['created_by', 'updated_by', 'deleted_by']);
        });
    }
}
