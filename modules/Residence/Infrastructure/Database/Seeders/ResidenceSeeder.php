<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Seeders;

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Residence\Infrastructure\Models\Residence;

/**
 * @phpstan-import-type ResidenceFactoryResponse from \Modules\Residence\Infrastructure\Database\Factories\ResidenceFactory
 */
final class ResidenceSeeder extends Seeder
{
    /**
     * @param array<int,array{id:string,email:string,name:string,surname:string,password:string}> $providers
     * @param array<int,array{id:string,name:string,created_at:string,updated_at:string}>         $types
     * @param array<int,array{id:string,name:string,created_at:string,updated_at:string}>         $features
     *
     * @phpstan-return array{residences:array<int,ResidenceFactoryResponse>}
     */
    public function run(
        array $providers,
        array $types,
        array $features,
        int $count,
        bool $persiste
    ): array {
        $residences = Residence::factory()
            ->count(count: $count)
            ->make()
            ->map(static fn (Residence $residence) => [
                ...$residence->getAttributes(),
                'user_id' => value(static fn (array $values) => $values['id'], Arr::random(array: $providers)),
                'type_id' => value(static fn (array $values) => $values['id'], Arr::random(array: $types)),
            ])
            ->toArray();
        if ($persiste) {
            DB::table(table: 'residences')->insert(values: $residences);
            DB::table(table: 'feature_residence')->insert(values: Arr::flatten(depth: 1, array: array_map(
                array: Arr::pluck(array: $residences, value: 'id'),
                callback: static fn (string $residence_id): array => array_map(
                    array: collect(value: $features)->pluck(value: 'id')->random(number: rand(min: 1, max: \count(value: $features) - 1))->toArray(),
                    callback: static fn (string $feature_id): array => ['residence_id' => $residence_id, 'feature_id' => $feature_id]
                )
            )));
        }

        return ['residences' => $residences];
    }
}
