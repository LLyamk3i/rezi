<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Services\Seeder;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Infrastructure\Models\User;

final class CreateUsersService
{
    /**
     * @param array<int,array{email:string,name:string,surname:string,password:string}> $basic
     *
     * @return array<int,array{id:string,email:string,name:string,surname:string,password:string}>
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
