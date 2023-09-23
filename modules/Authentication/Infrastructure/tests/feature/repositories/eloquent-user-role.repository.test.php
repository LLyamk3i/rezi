<?php

use Modules\Authentication\Domain\Enums\Roles;
use Illuminate\Support\Facades\Artisan;
use Modules\Authentication\Infrastructure\Models\Role;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Infrastructure\Eloquent\Repositories\EloquentUserRoleRepository;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);
// uses(
//     \Tests\TestCase::class,
//     \Illuminate\Foundation\Testing\LazilyRefreshDatabase::class,
// );
test(description: 'it can verify if user has owner role', closure: function () {

    Artisan::call(command: 'migrate', parameters: ['--path' => 'Modules/Authentication/Infrastructure/Database/Migrations']);

    $repository = new EloquentUserRoleRepository();

    $user = User::factory()->create();

    $user->roles()->attach(id: [
        Role::factory()->create(attributes: ['name' => Roles::Owner->value])->id,
    ]);

    $result = $repository->verify(user: new Ulid(value: $user->id), roles: [Roles::Owner]);

    expect(value: $result)->toBeTrue();
});

test(description: 'it can verify if user has owner and admin roles', closure: function () {

    Artisan::call(command: 'migrate', parameters: ['--path' => 'Modules/Authentication/Infrastructure/Database/Migrations']);

    $repository = new EloquentUserRoleRepository();

    $user = User::factory()->create();

    $user->roles()->attach(id: [
        Role::factory()->create(attributes: ['name' => Roles::Owner->value])->id,
        Role::factory()->create(attributes: ['name' => Roles::Admin->value])->id,
    ]);

    $result = $repository->verify(user: new Ulid(value: $user->id), roles: [Roles::Owner, Roles::Admin]);

    expect(value: $result)->toBeTrue();
});

test(description: 'it cannot verify if user has owner role', closure: function () {

    Artisan::call(command: 'migrate', parameters: ['--path' => 'Modules/Authentication/Infrastructure/Database/Migrations']);

    $repository = new EloquentUserRoleRepository();

    $user = User::factory()->create();

    $result = $repository->verify(user: new Ulid(value: $user->id), roles: [Roles::Owner]);

    expect(value: $result)->toBeFalse();
});
