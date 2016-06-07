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
            $model->created_by = auth($model->getAuthGuard())->check() ? auth($model->getAuthGuard())->id() : 0;
        }

        if (! $model->updated_by) {
            $model->updated_by = auth($model->getAuthGuard())->check() ? auth($model->getAuthGuard())->id() : 0;
        }
    }

    /**
     * Model's updating event hook.
     *
     * @param \Yajra\Auditable\AuditableTrait $model
     */
    public function updating($model)
    {
        if (! $model->updated_by) {
            $model->updated_by = auth($model->getAuthGuard())->check() ? auth($model->getAuthGuard())->id() : 0;
        }
    }
}
