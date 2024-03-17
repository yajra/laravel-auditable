<?php

use Yajra\Auditable\Tests\App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\be;

test('it can add auditing fields', function () {
    $user = User::forceCreate([
        'name' => 'J1',
        'email' => 'email1@email.com',
    ]);

    assertDatabaseCount('users', 1);
    expect($user->created_by)->toBeNull();

    be($user);

    $user2 = User::forceCreate([
        'name' => 'J2',
        'email' => 'email2@email.com',
    ]);

    assertDatabaseCount('users', 2);
    expect($user2->created_by)->toBe(1);
    expect($user2->updated_by)->toBe(1);
});
