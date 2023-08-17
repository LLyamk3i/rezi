<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;

final class FeatureSeeder extends Seeder
{
    private const FEATURES = [
        'Sécurité', 'Wi-fi', 'Balcon', 'Accessibilité', 'Confort', 'Flexibilité',
    ];

    public function run(): void
    {
        DB::table(table: 'features')->insert(
            values: array_map(array: self::FEATURES, callback: static fn (string $feature): array => ['id' => Ulid::generate(), 'name' => $feature])
        );
    }
}
