<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Entities\User as Entity;
use Modules\Auth\Domain\Enums\Roles;
use Modules\Auth\Infrastructure\Eloquent\Repositories\EloquentAccountRepository;
use Modules\Auth\Infrastructure\Eloquent\Repositories\EloquentAuthRepository;
use Modules\Auth\Infrastructure\Models\Role;
use Modules\Auth\Infrastructure\Models\User as Model;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Symfony\Component\Uid\Ulid as SymphonyUlid;

use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertTrue;

uses(\Tests\SqliteTestCase::class);
// uses(
//     \Tests\TestCase::class,
//     \Illuminate\Foundation\Testing\LazilyRefreshDatabase::class,
// );

test(description: 'create method can create user with owner role', closure: function () {
    Artisan::call(command: 'migrate', parameters: ['--path' => 'modules/Auth/Infrastructure/Database/Migrations']);

    $role = Role::factory()->create(attributes: ['name' => Roles::OWNER]);

    $repository = new EloquentAccountRepository(repository: new EloquentAuthRepository());

    $entity = new Entity(
        id: new Ulid(value: SymphonyUlid::generate()),
        name: 'test',
        surname: 'test',
        email: 'test@test.com',
        password: 'test',
    );

    $result = $repository->create(user: $entity, roles: [$role->name]);

    assertTrue(condition: $result === true);

    assertDatabaseHas(table: 'users', data: [
        'id' => $entity->id->value,
        'name' => $entity->name,
        'surname' => $entity->surname,
        'email' => $entity->email,
    ]);

    assertDatabaseHas(table: 'role_user', data: [
        'user_id' =>  $entity->id->value,
        'role_id' => $role->id,
    ]);
});

test(description: 'create method can create user with owner and admin role', closure: function () {
    Artisan::call(command: 'migrate', parameters: ['--path' => 'modules/Auth/Infrastructure/Database/Migrations']);

    $roles = Role::factory()
        ->count(count: 2)
        ->sequence(['name' => Roles::OWNER], ['name' => Roles::ADMIN])
        ->create();

    $repository = new EloquentAccountRepository(repository: new EloquentAuthRepository());

    $entity = new Entity(
        id: new Ulid(value: SymphonyUlid::generate()),
        name: 'test',
        surname: 'test',
        email: 'test@test.com',
        password: 'test',
    );

    $result = $repository->create(user: $entity, roles: $roles->pluck(value: 'name')->toArray());

    assertTrue(condition: $result === true);

    assertDatabaseHas(table: 'users', data: [
        'id' => $entity->id->value,
        'name' => $entity->name,
        'surname' => $entity->surname,
        'email' => $entity->email,
    ]);

    assertDatabaseHas(table: 'role_user', data: [
        'user_id' =>  $entity->id->value,
        'role_id' => $roles->first()->id,
    ]);
    assertDatabaseHas(table: 'role_user', data: [
        'user_id' =>  $entity->id->value,
        'role_id' => $roles->last()->id,
    ]);
});

test(description: 'create method cannot create user without role', closure: function () {
    Artisan::call(command: 'migrate', parameters: ['--path' => 'modules/Auth/Infrastructure/Database/Migrations']);

    $repository = new EloquentAccountRepository(repository: new EloquentAuthRepository());

    $result = $repository->create(roles: [], user: new Entity(
        id: new Ulid(value: SymphonyUlid::generate()),
        name: 'test',
        surname: 'test',
        email: 'test@test.com',
        password: 'test',
    ));

    assertTrue(condition: $result === false);
    assertTrue(condition: Model::count() === 0);
    assertTrue(condition: DB::table(table: 'role_user')->count() === 0);
});
