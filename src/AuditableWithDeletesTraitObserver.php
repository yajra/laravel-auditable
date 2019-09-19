<?php

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Model;

class AuditableWithDeletesTraitObserver
{
    /**
     * Model's deleting event hook
     *
     * @param Model $model
     */
    public function deleting(Model $model)
    {
        $deletedBy = $model->getDeletedByColumn();

        $model->$deletedBy = $this->getAuthenticatedUserId();
        $model->save();
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
     * Model's restoring event hook
     *
     * @param Model $model
     */
    public function restoring(Model $model)
    {
        $deletedBy = $model->getDeletedByColumn();

        $model->$deletedBy = null;
    }
}
