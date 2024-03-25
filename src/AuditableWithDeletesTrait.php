<?php

declare(strict_types=1);

namespace Yajra\Auditable;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property \Illuminate\Database\Eloquent\Model $deleter
 */
trait AuditableWithDeletesTrait
{
    use AuditableTrait;

    /**
     * Boot the audit trait for a model.
     */
    public static function bootAuditableWithDeletesTrait(): void
    {
        static::observe(new AuditableWithDeletesTraitObserver());
    }

    /**
     * Get user model who deleted the record.
     */
    public function deleter(): BelongsTo
    {
        return $this->belongsTo($this->getUserClass(), $this->getDeletedByColumn())
            ->withDefault(config('auditable.defaults.deleter'));
    }

    /**
     * Get column name for deleted by.
     */
    public function getDeletedByColumn(): string
    {
        return defined('static::DELETED_BY') ? static::DELETED_BY : 'deleted_by';
    }

    /**
     * Get deleted by user full name.
     */
    public function getDeletedByNameAttribute(): string
    {
        return $this->deleter->name ?? '';
    }
}
