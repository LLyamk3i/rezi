<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Modules\Authentication\Domain\Entities\User as Entity;
use Modules\Authentication\Domain\Enums\Roles;
use Modules\Authentication\Infrastructure\Eloquent\Repositories\EloquentAccountRepository;
use Modules\Authentication\Infrastructure\Models\Role;
use Modules\Authentication\Infrastructure\Models\User as Model;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Symfony\Component\Uid\Ulid as SymphonyUlid;

use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertTrue;

uses(
    \Tests\TestCase::class,
    \Illuminate\Foundation\Testing\RefreshDatabase::class,
);

function account_repository(): EloquentAccountRepository
{
    return resolve(name: EloquentAccountRepository::class);
}

function user_entity_factory(): \Modules\Authentication\Domain\Entities\User
{
    return new Entity(
        id: new Ulid(value: SymphonyUlid::generate()),
        forename: 'test',
        surname: 'test',
        email: 'test@test.com',
        password: 'test',
    );
}

test(description: 'it can create user with owner role', closure: function (): void {
    Artisan::call(command: 'migrate', parameters: ['--path' => 'Modules/Authentication/Infrastructure/Database/Migrations']);

    $role = Role::factory()->create(attributes: ['name' => Roles::Owner]);

    $entity = user_entity_factory();

    $result = account_repository()->create(user: $entity, roles: [$role->name]);

    assertTrue(condition: $result);

    assertDatabaseHas(table: 'users', data: [
        'id' => $entity->id->value,
        'forename' => $entity->forename,
        'surname' => $entity->surname,
        'email' => $entity->email,
    ]);

    assertDatabaseHas(table: 'role_user', data: [
        'user_id' =>  $entity->id->value,
        'role_id' => $role->id,
    ]);
});

test(description: 'it can create user with owner and admin role', closure: function (): void {
    Artisan::call(command: 'migrate', parameters: ['--path' => 'Modules/Authentication/Infrastructure/Database/Migrations']);

    $roles = Role::factory()
        ->count(count: 2)
        ->sequence(['name' => Roles::Owner], ['name' => Roles::Admin])
        ->create();

    $entity = user_entity_factory();

    $result = account_repository()->create(user: $entity, roles: $roles->pluck(value: 'name')->toArray());

    assertTrue(condition: $result);

    assertDatabaseHas(table: 'users', data: [
        'id' => $entity->id->value,
        'forename' => $entity->forename,
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

test(description: 'it cannot create user without role', closure: function (): void {
    Artisan::call(command: 'migrate', parameters: ['--path' => 'Modules/Authentication/Infrastructure/Database/Migrations']);

    $result = account_repository()->create(roles: [], user: new Entity(
        id: new Ulid(value: SymphonyUlid::generate()),
        forename: 'test',
        surname: 'test',
        email: 'test@test.com',
        password: 'test',
    ));

    assertTrue(condition: $result === false);
    assertTrue(condition: Model::count() === 0);
    assertTrue(condition: DB::table(table: 'role_user')->count() === 0);
});
