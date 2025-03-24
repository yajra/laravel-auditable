<?php

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Model $creator
 * @property Model $updater
 * @property bool $auditing
 */
trait AuditableTrait
{
    protected static bool $auditing = true;

    /**
     * Boot the audit trait for a model.
     */
    public static function bootAuditableTrait(): void
    {
        static::observe(new AuditableTraitObserver);
    }

    /**
     * Disable auditing.
     */
    public static function withoutAudits(callable $callback)
    {
        $previousState = static::$auditing;
        static::$auditing = false;

        try {
            return $callback();
        } finally {
            static::$auditing = $previousState;
        }
    }

    /**
     * Check is auditing is enabled.
     */
    public function isAuditable(): bool
    {
        return static::$auditing;
    }

    /**
     * Get user model who created the record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo($this->getUserClass(), $this->getCreatedByColumn())
            ->withDefault(config('auditable.defaults.creator'));
    }

    /**
     * Get user class.
     */
    protected function getUserClass(): string
    {
        if (property_exists($this, 'auditUser')) {
            return $this->auditUser;
        }

        return config('auth.providers.users.model', 'App\User');
    }

    /**
     * Get column name for created by.
     */
    public function getCreatedByColumn(): string
    {
        return defined('static::CREATED_BY') ? static::CREATED_BY : 'created_by';
    }

    /**
     * Get user model who updated the record.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo($this->getUserClass(), $this->getUpdatedByColumn())
            ->withDefault(config('auditable.defaults.updater'));
    }

    /**
     * Get column name for updated by.
     */
    public function getUpdatedByColumn(): string
    {
        return defined('static::UPDATED_BY') ? static::UPDATED_BY : 'updated_by';
    }

    /**
     * Get created by user full name.
     */
    public function getCreatedByNameAttribute(): string
    {
        return $this->creator->name ?? '';
    }

    /**
     * Get updated by user full name.
     */
    public function getUpdatedByNameAttribute(): string
    {
        return $this->updater->name ?? '';
    }

    /**
     * Query scope to limit results to own records.
     */
    public function scopeOwned(Builder $query): Builder
    {
        return $query->where($this->getQualifiedUserIdColumn(), auth()->id());
    }

    /**
     * Get qualified column name for user id.
     */
    public function getQualifiedUserIdColumn(): string
    {
        return $this->getTable().'.'.$this->getUserInstance()->getKey();
    }

    /**
     * Get Laravel's user class instance.
     */
    public function getUserInstance(): Model
    {
        $class = $this->getUserClass();

        return new $class;
    }
}
