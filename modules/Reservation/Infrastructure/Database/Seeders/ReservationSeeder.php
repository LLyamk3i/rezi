<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Database\Seeders;

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Reservation\Infrastructure\Models\Reservation;

/**
 * @phpstan-import-type ResidenceFactoryResponse from \Modules\Residence\Infrastructure\Database\Factories\ResidenceFactory
 * @phpstan-import-type ReservationFactoryResponse from \Modules\Reservation\Infrastructure\Database\Factories\ReservationFactory
 */
final class ReservationSeeder extends Seeder
{
    /**
     * @param array<int,array{id:string,email:string,name:string,surname:string,password:string}> $admins
     * @param array<int,array{id:string,email:string,name:string,surname:string,password:string}> $providers
     *
     * @phpstan-param array{residences:array<int,ResidenceFactoryResponse>} $residences
     *
     * @phpstan-return array{reservations:array<int,ReservationFactoryResponse>}
     */
    public function run(array $admins, array $providers, array $residences, int $count, bool $persiste): array
    {
        $clients = [...$admins, ...$providers];

        $bookables = Arr::where(array: $residences, callback: static fn (array $residence): bool => $residence['visible'] === 1);

        $reservations = Reservation::factory()
            ->count(count: $count)
            ->make()
            ->map(callback: static fn (Reservation $reservation): array => [
                ...$reservation->getAttributes(),
                'user_id' => value(static fn (array $values) => $values['id'], Arr::random(array: $clients)),
                'residence_id' => value(static fn (array $values) => $values['id'], Arr::random(array: $bookables)),
            ])
            ->toArray();

        if ($persiste) {
            DB::table(table: 'reservations')->insert(values: $reservations);
        }

        return ['reservations' => $reservations];
    }
}
