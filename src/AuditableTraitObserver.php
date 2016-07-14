<?php

namespace Yajra\Auditable;

/**
 * Class AuditableObserver
 *
 * @package Yajra\Auditable
 */
class AuditableTraitObserver
{
    /**
     * Model's creating event hook.
     *
     * @param \Yajra\Auditable\AuditableTrait $model
     */
    public function creating($model)
    {
        if (! $model->created_by) {
            $model->created_by = $this->getAuthenticatedUserId();
        }

        if (! $model->updated_by) {
            $model->updated_by = $this->getAuthenticatedUserId();
        }
    }

    /**
     * Get authenticated user id depending on model's auth guard.
     *
     * @return int
     */
    protected function getAuthenticatedUserId()
    {
        return auth()->check() ? auth()->id() : 0;
    }

    /**
     * Model's updating event hook.
     *
     * @param \Yajra\Auditable\AuditableTrait $model
     */
    public function updating($model)
    {
        if (! $model->updated_by) {
            $model->updated_by = $this->getAuthenticatedUserId();
        }
    }
}
