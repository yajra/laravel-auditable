<?php

namespace Yajra\Auditable;

/**
 * @property mixed deleter
 */
trait AuditableWithDeletesTrait
{
    use AuditableTrait;

    /**
     * Boot the audit trait for a model.
     *
     * @return void
     */
    public static function bootAuditableWithDeletesTrait()
    {
        static::observe(new AuditableWithDeletesTraitObserver);
    }

    /**
     * Get user model who deleted the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deleter()
    {
        return $this->belongsTo($this->getUserClass(), $this->getDeletedByColumn())->withDefault();
    }

    /**
     * Get column name for deleted by.
     *
     * @return string
     */
    public function getDeletedByColumn()
    {
        return defined('static::DELETED_BY') ? static::DELETED_BY : 'deleted_by';
    }

    /**
     * Get deleted by user full name.
     *
     * @return string
     */
    public function getDeletedByNameAttribute()
    {
        return $this->deleter->name ?? '';
    }
}
