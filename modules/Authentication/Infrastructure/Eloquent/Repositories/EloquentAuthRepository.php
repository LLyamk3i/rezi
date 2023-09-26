<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\Entities\User;
use Modules\Authentication\Domain\Repositories\AuthRepository;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class EloquentAuthRepository implements AuthRepository
{
    public function register(User $user): bool
    {
        return DB::table(table: 'users')->insert(values: [
            'id' => $user->id->value,
            'forename' => $user->forename,
            'surname' => $user->surname,
            'email' => $user->email,
            'password' => Hash::make(value: string_value(value: $user->password)),
        ]);
    }

    /**
     * @param array<int,\Modules\Authentication\Domain\Enums\Roles> $roles
     */
    public function bind(Ulid $user, array $roles): bool
    {
        if ($roles === []) {
            return false;
        }
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
