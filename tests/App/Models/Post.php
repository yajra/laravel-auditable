<?php

declare(strict_types=1);

namespace Yajra\Auditable\Tests\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Auditable\AuditableWithDeletesTrait;

class Post extends Model
{
    use AuditableWithDeletesTrait;
    use SoftDeletes;

    protected $guarded = [];
}
