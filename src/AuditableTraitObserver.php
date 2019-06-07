<?php

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class AuditableTraitObserver
{
    /**
     * Model's creating event hook.
     *
     * @param Model $model
     */
    public function creating(Model $model)
    {
        $createdBy = $model->getCreatedByColumn();
        $updatedBy = $model->getUpdatedByColumn();

        if (! $model->$createdBy) {
            $model->$createdBy = $this->getAuthenticatedUserId();
        }

        if (! $model->$updatedBy) {
            $model->$updatedBy = $this->getAuthenticatedUserId();
        }
    }

    /**
     * Get authenticated user id depending on model's auth guard.
     *
     * @return int
     */
    protected function getAuthenticatedUserId()
    {
        return auth()->check() ? auth()->id() : null;
    }

    /**
     * Model's updating event hook.
     *
     * @param Model $model
     */
    public function updating(Model $model)
    {
        $updatedBy = $model->getUpdatedByColumn();

        if (! $model->isDirty($updatedBy)) {
            $model->$updatedBy = $this->getAuthenticatedUserId();
        }
    }

    /**
     * Model's deleting event hook
     *
     * @param Model $model
     */
    public function deleting(Model $model)
    {
        $deletedBy = $model->getDeletedByColumn();

        if (Schema::hasColumn($model->getTable(), $deletedBy)) {
            if (! $model->$deletedBy) {
                $model->$deletedBy = $this->getAuthenticatedUserId();
            }
        }
    }
}
