<?php

use Modules\Auth\Domain\Enums\Roles;
use Illuminate\Support\Facades\Artisan;
use Modules\Auth\Infrastructure\Models\Role;
use Modules\Auth\Infrastructure\Models\User;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Auth\Infrastructure\Eloquent\Repositories\EloquentUserRoleRepository;

// uses(\Tests\SqliteTestCase::class);
uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\LazilyRefreshDatabase::class,
);
test(description: 'verify method can verify if user has owner role', closure: function () {

    // Artisan::call(command: 'migrate', parameters: ['--path' => 'modules/Auth/Infrastructure/Database/Migrations']);

    $repository = new EloquentUserRoleRepository();

    $user = User::factory()->create();

    $user->roles()->attach(id: [
        Role::factory()->create(attributes: ['name' => Roles::OWNER->value])->id,
    ]);

    $result = $repository->verify(user: new Ulid(value: $user->id), roles: [Roles::OWNER->value]);

    expect(value: $result)->toBeTrue();
});

test(description: 'verify method can verify if user has owner and admin roles', closure: function () {

    // Artisan::call(command: 'migrate', parameters: ['--path' => 'modules/Auth/Infrastructure/Database/Migrations']);

    $repository = new EloquentUserRoleRepository();

    $user = User::factory()->create();

    $user->roles()->attach(id: [
        Role::factory()->create(attributes: ['name' => Roles::OWNER->value])->id,
        Role::factory()->create(attributes: ['name' => Roles::ADMIN->value])->id,
    ]);

    $result = $repository->verify(user: new Ulid(value: $user->id), roles: [Roles::OWNER->value, Roles::ADMIN->value]);

    expect(value: $result)->toBeTrue();
});

test(description: 'verify method cannot verify if user has owner role', closure: function () {

    // Artisan::call(command: 'migrate', parameters: ['--path' => 'modules/Auth/Infrastructure/Database/Migrations']);

    $repository = new EloquentUserRoleRepository();

    $user = User::factory()->create();

    $result = $repository->verify(user: new Ulid(value: $user->id), roles: [Roles::OWNER->value]);

    expect(value: $result)->toBeFalse();
});
