<?php

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuditableTrait
 *
 * @property int created_by
 * @property int updated_by
 * @method getTable()
 * @method observe($observer)
 * @method belongsTo($related, $foreignKey = null, $otherKey = null, $relation = null)
 * @package Yajra\Auditable
 */
trait AuditableTrait
{
    /**
     * Boot the audit trait for a model.
     *
     * @return void
     */
    public static function bootAuditableTrait()
    {
        static::observe(new AuditableTraitObserver);
    }

    /**
     * Get user model who created the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(get_class(Auth::user()), $this->getCreatedByColumn());
    }

    /**
     * Get column name for created by.
     *
     * @return string
     */
    protected function getCreatedByColumn()
    {
        return 'created_by';
    }

    /**
     * Get user model who updated the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo(get_class(Auth::user()), $this->getUpdatedByColumn());
    }

    /**
     * Get column name for updated by.
     *
     * @return string
     */
    protected function getUpdatedByColumn()
    {
        return 'updated_by';
    }

    /**
     * Get created by user full name.
     *
     * @return string
     */
    public function getCreatedByNameAttribute()
    {
        if ($this->{$this->getCreatedByColumn()}) {
            $user = $this->getUserInstance()->find($this->{$this->getCreatedByColumn()});

            return $user->first_name . ' ' . $user->last_name;
        }

        return '';
    }

    /**
     * Get Laravel's user class instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getUserInstance()
    {
        $class = get_class(Auth::user());

        return new $class;
    }

    /**
     * Get updated by user full name.
     *
     * @return string
     */
    public function getUpdatedByNameAttribute()
    {
        if ($this->{$this->getUpdatedByColumn()}) {
            $user = $this->getUserInstance()->find($this->{$this->getUpdatedByColumn()});

            return $user->first_name . ' ' . $user->last_name;
        }

        return '';
    }

    /**
     * Query scope to limit results to own records.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOwned(Builder $query)
    {
        return $query->where($this->getQualifiedUserIdColumn(), Auth::id());
    }

    /**
     * Get qualified column name for user id.
     *
     * @return string
     */
    public function getQualifiedUserIdColumn()
    {
        return $this->getTable() . '.' . $this->getUserInstance()->getKey();
    }
}
