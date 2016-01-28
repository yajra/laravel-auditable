<?php

namespace Yajra\Auditable;

use Illuminate\Support\Facades\Auth;

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
            $model->created_by = Auth::check() ? Auth::id() : 0;
        }

        if (! $model->updated_by) {
            $model->updated_by = Auth::check() ? Auth::id() : 0;
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
            $model->updated_by = Auth::check() ? Auth::id() : 0;
        }
    }
}
