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
            $model->created_by = $this->getAuthenticatedUserId($model);
        }

        if (! $model->updated_by) {
            $model->updated_by = $this->getAuthenticatedUserId($model);
        }
    }

    /**
     * Get authenticated user id depending on model's auth guard.
     *
     * @param \Yajra\Auditable\AuditableTrait $model
     * @return int
     */
    protected function getAuthenticatedUserId($model)
    {
        return auth($model->getAuthGuard())->check() ? auth($model->getAuthGuard())->id() : 0;
    }

    /**
     * Model's updating event hook.
     *
     * @param \Yajra\Auditable\AuditableTrait $model
     */
    public function updating($model)
    {
        if (! $model->updated_by) {
            $model->updated_by = $this->getAuthenticatedUserId($model);
        }
    }
}
