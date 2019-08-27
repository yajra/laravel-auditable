<?php

namespace Yajra\Auditable;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AuditableServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro('auditable', function() {
            $this->unsignedBigInteger('created_by')->nullable()->index();
            $this->unsignedBigInteger('updated_by')->nullable()->index();
        });

        Blueprint::macro('dropAuditable', function() {
            $this->dropColumn(['created_by', 'updated_by']);
        });

        Blueprint::macro('auditableWithDeletes', function() {
            $this->unsignedBigInteger('created_by')->nullable()->index();
            $this->unsignedBigInteger('updated_by')->nullable()->index();
            $this->unsignedBigInteger('deleted_by')->nullable()->index();
        });

        Blueprint::macro('dropAuditableWithDeletes', function() {
            $this->dropColumn(['created_by', 'updated_by', 'deleted_by']);
        });
    }
}
