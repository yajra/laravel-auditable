<?php

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Model;

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
     * Set updatedBy column on save if value is not the same.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function saved(Model $model)
    {
        $updatedBy = $model->getUpdatedByColumn();

        if ($this->getAuthenticatedUserId() && $model->$updatedBy <> $this->getAuthenticatedUserId()) {
            $model->$updatedBy = $this->getAuthenticatedUserId();
            $model->save();
        }
    }
}
