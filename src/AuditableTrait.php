<?php

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property mixed creator
 * @property mixed updater
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
        return $this->belongsTo($this->getUserClass(), $this->getCreatedByColumn())
                    ->withDefault(config('auditable.defaults.creator'));
    }

    /**
     * Get user class.
     *
     * @return string
     */
    protected function getUserClass()
    {
        if (property_exists($this, 'auditUser')) {
            return $this->auditUser;
        }

        return config('auth.providers.users.model', 'App\User');
    }

    /**
     * Get column name for created by.
     *
     * @return string
     */
    public function getCreatedByColumn()
    {
        return defined('static::CREATED_BY') ? static::CREATED_BY : 'created_by';
    }

    /**
     * Get user model who updated the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo($this->getUserClass(), $this->getUpdatedByColumn())
                    ->withDefault(config('auditable.defaults.updater'));
    }

    /**
     * Get column name for updated by.
     *
     * @return string
     */
    public function getUpdatedByColumn()
    {
        return defined('static::UPDATED_BY') ? static::UPDATED_BY : 'updated_by';
    }

    /**
     * Get created by user full name.
     *
     * @return string
     */
    public function getCreatedByNameAttribute()
    {
        return $this->creator->name ?? '';
    }

    /**
     * Get updated by user full name.
     *
     * @return string
     */
    public function getUpdatedByNameAttribute()
    {
        return $this->updater->name ?? '';
    }

    /**
     * Query scope to limit results to own records.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOwned(Builder $query)
    {
        return $query->where($this->getQualifiedUserIdColumn(), auth()->id());
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

    /**
     * Get Laravel's user class instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getUserInstance()
    {
        $class = $this->getUserClass();

        return new $class;
    }
}
