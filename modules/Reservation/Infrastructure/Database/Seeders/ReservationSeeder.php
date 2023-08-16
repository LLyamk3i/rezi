<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class ReservationSeeder extends Seeder
{
    /**
     * @param array<int,\Modules\Auth\Infrastructure\Models\User>           $clients
     * @param array<int,\Modules\Residence\Infrastructure\Models\Residence> $residence
     */
    public function run(array $clients, array $residence): void
    {
        $clients = DB::table(table: 'users');
    }
}
