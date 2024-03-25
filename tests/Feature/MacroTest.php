<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;

test('it has blueprint macro', function () {
    $this->assertTrue(Blueprint::hasMacro('auditable'));
    $this->assertTrue(Blueprint::hasMacro('dropAuditable'));
    $this->assertTrue(Blueprint::hasMacro('auditableWithDeletes'));
    $this->assertTrue(Blueprint::hasMacro('dropAuditableWithDeletes'));
});
