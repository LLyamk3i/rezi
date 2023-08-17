<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;

final class TypeSeeder extends Seeder
{
    private const TYPES = [
        'Appartement', 'Maison', 'Villa', 'Chalet', 'Studio', 'Loft', 'Cabane', 'Cottage',
        'Penthouse', "Chambre d'hôtel", 'Auberge', 'Bungalow', 'Manoir', 'Gîte rural', 'Hôtel', 'Château',
    ];

    public function run(): void
    {
        DB::table(table: 'types')->insert(
            values: array_map(array: self::TYPES, callback: static fn (string $type): array => ['id' => Ulid::generate(), 'name' => $type])
        );
    }
}
