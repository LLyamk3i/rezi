<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Auth\Domain\Repositories\AuthRepository;

final class EloquentAuthRepository implements AuthRepository
{
    public function register(
        string $id,
        string $name,
        string $surname,
        string $email,
        string $password
    ): bool {
        return DB::table(table: 'users')->insert(values: [
            'id' => $id,
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => Hash::make(value: $password),

        ]);
    }

    public function bind(Ulid $user, array $roles): bool
    {

        $data = DB::table(table: 'roles')
            ->whereIn(column: 'name', values: $roles)
            ->get(columns: ['id'])
            ->map(callback: static fn (array $data) => [
                'user_id' => $user->value,
                'role_id' => $data['id'],
            ]);

        return DB::table(table: 'role_user')->insert(values: $data->toArray());
    }
}
