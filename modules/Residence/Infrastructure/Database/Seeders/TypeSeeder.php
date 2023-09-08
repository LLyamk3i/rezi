<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;

/**
 * @phpstan-import-type TypeFactoryResponse from \Modules\Residence\Infrastructure\Database\Factories\TypeFactory
 */
final class TypeSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    private const TYPES = [
        'Appartement', 'Maison', 'Villa', 'Chalet', 'Studio', 'Loft', 'Cabane', 'Cottage',
        'Penthouse', "Chambre d'hôtel", 'Auberge', 'Bungalow', 'Manoir', 'Gîte rural', 'Hôtel', 'Château',
    ];

    /**
     * @phpstan-return array{types:array<int,TypeFactoryResponse>}
     */
    public function run(bool $persiste): array
    {
        $types = array_map(array: self::TYPES, callback: static fn (string $type): array => [
            'id' => Ulid::generate(),
            'name' => $type,
            'created_at' => (string) now(),
            'updated_at' => (string) now(),
        ]);
        if ($persiste) {
            DB::table(table: 'types')->insert(values: $types);
        }

        return ['types' => $types];
    }
}
