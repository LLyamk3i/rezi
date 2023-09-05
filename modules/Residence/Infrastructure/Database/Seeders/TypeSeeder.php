<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\DB;

final class TypeSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    private const TYPES = [
        'Appartement', 'Maison', 'Villa', 'Chalet', 'Studio', 'Loft', 'Cabane', 'Cottage',
        'Penthouse', "Chambre d'hôtel", 'Auberge', 'Bungalow', 'Manoir', 'Gîte rural', 'Hôtel', 'Château',
    ];

    /**
     * @return array{types:array<int,array{id:string,name:string,created_at:string,updated_at:string}>}
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
