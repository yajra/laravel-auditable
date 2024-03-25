<?php

declare(strict_types=1);

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Model;

class AuditableWithDeletesTraitObserver
{
    /**
     * Model's deleting event hook
     */
    public function deleting(Model $model): void
    {
        if (method_exists($model, 'getDeletedByColumn')) {
            $deletedBy = $model->getDeletedByColumn();

            $model->$deletedBy = $this->getAuthenticatedUserId();
            $model->save();
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
     * Model's restoring event hook
     */
    public function restoring(Model $model): void
    {
        if (method_exists($model, 'getDeletedByColumn')) {
            $deletedBy = $model->getDeletedByColumn();

            $model->$deletedBy = null;
        }
    }
}
