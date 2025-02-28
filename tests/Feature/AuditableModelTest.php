<?php

use Yajra\Auditable\Tests\App\Models\Post;
use Yajra\Auditable\Tests\App\Models\User;

use function Pest\Laravel\actingAs;

test('a user model is auditable', function () {
    $user = User::forceCreate([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    expect($user->created_by)->toBe(null);
    expect($user->updated_by)->toBe(null);

    actingAs($user);

    $jane = User::forceCreate([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
    ]);

    expect($jane->created_by)->toBe($user->id);
    expect($jane->updated_by)->toBe($user->id);
});

test('a post can be soft deleted with audit', function () {
    $user = User::forceCreate([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    actingAs($user);

    $post = Post::forceCreate([
        'title' => 'Hello World',
    ]);

    expect($post->created_by)->toBe($user->id);
    expect($post->updated_by)->toBe($user->id);
    expect($post->deleted_by)->toBe(null);

    $post->delete();

    expect($post->created_by)->toBe($user->id);
    expect($post->updated_by)->toBe($user->id);
    expect($post->deleted_by)->toBe($user->id);
});
