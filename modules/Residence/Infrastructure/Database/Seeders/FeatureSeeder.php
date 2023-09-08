<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;

/**
 * @phpstan-import-type FeatureFactoryResponse from \Modules\Residence\Infrastructure\Database\Factories\FeatureFactory
 */
final class FeatureSeeder extends Seeder
{
    private const FEATURES = [
        'Sécurité', 'Wi-fi', 'Balcon', 'Accessibilité', 'Confort', 'Flexibilité',
    ];

    /**
     * @phpstan-return array{features:array<int,FeatureFactoryResponse>}
     */
    public function run(bool $persiste): array
    {
        $features = array_map(array: self::FEATURES, callback: static fn (string $feature): array => [
            'id' => Ulid::generate(),
            'name' => $feature,
            'created_at' => (string) now(),
            'updated_at' => (string) now(),
        ]);
        if ($persiste) {
            DB::table(table: 'features')->insert(values: $features);
        }

        return ['features' => $features];
    }
}
