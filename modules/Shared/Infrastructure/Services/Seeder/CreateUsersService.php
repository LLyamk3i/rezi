<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Services\Seeder;

use Illuminate\Database\Eloquent\Model;
use Modules\Authentication\Infrastructure\Models\User;

/**
 * @phpstan-import-type UserRecord from \Modules\Admin\Infrastructure\Database\Records\OwnerRecord
 * @phpstan-import-type UserFactoryResponse from \Modules\Authentication\Infrastructure\Database\Factories\UserFactory
 */
final class CreateUsersService
{
    /**
     * @phpstan-param array<int,UserRecord> $basic
     *
     * @phpstan-return array<int,UserFactoryResponse>
     */
    public function run(int $count, array $basic = []): array
    {
        return User::factory()
            ->count(count: $count)
            ->make()
            ->map(callback: static function (Model $model, int $key) use ($basic) {
                if (\in_array(needle: $key, haystack: array_keys(array: $basic), strict: true)) {
                    return [...$model->getAttributes(), ...$basic[$key]];
                }

                return $model->getAttributes();
            })->toArray();
    }
}
