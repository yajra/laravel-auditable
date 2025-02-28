<?php

declare(strict_types=1);

namespace Yajra\Auditable\Tests\App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Yajra\Auditable\AuditableTrait;

class User extends Authenticatable
{
    use AuditableTrait;

    protected $guarded = [];
}
