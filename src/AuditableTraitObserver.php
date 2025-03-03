<?php

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Model;

class AuditableTraitObserver
{
    /**
     * Model's creating event hook.
     */
    public function creating(Model $model): void
    {
        if (method_exists($model, 'getCreatedByColumn')) {
            $createdBy = $model->getCreatedByColumn();

            if (! $model->$createdBy) {
                $model->$createdBy = $this->getAuthenticatedUserId();
            }
        }

        if (method_exists($model, 'getUpdatedByColumn')) {
            $updatedBy = $model->getUpdatedByColumn();

            if (! $model->$updatedBy) {
                $model->$updatedBy = $this->getAuthenticatedUserId();
            }
        }
    }

    /**
     * Get authenticated user id depending on model's auth guard.
     */
    protected function getAuthenticatedUserId(): int|string|null
    {
        return auth()->check() ? auth()->id() : null;
    }

    /**
     * Model's updating event hook.
     */
    public function updating(Model $model): void
    {
        if (method_exists($model, 'getUpdatedByColumn')) {
            $updatedBy = $model->getUpdatedByColumn();

            if (! $model->isDirty($updatedBy)) {
                $model->$updatedBy = $this->getAuthenticatedUserId();
            }
        }
    }

    /**
     * Set updatedBy column on save if value is not the same.
     */
    public function saved(Model $model): void
    {
        if (method_exists($model, 'getUpdatedByColumn')) {
            $updatedBy = $model->getUpdatedByColumn();

            if ($this->getAuthenticatedUserId() && $this->getAuthenticatedUserId() != $model->$updatedBy && $model->isDirty()) {
                $model->$updatedBy = $this->getAuthenticatedUserId();
                $model->save();
            }
        }
    }
}
