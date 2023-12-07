<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Console\View\Components\TwoColumnDetail;

final class DatabaseSeeder extends Seeder
{
    private const PERSISTE = true;

    private const SEEDERS = [
        \Modules\Authentication\Infrastructure\Database\Seeders\RoleTableSeeder::class => [],
        \Modules\Admin\Infrastructure\Database\Seeders\OwnerSeeder::class => ['count' => 1],
        \Modules\Admin\Infrastructure\Database\Seeders\AdminSeeder::class => ['count' => 5],
        \Modules\Authentication\Infrastructure\Database\Seeders\ProviderSeeder::class => ['count' => 15],
        \Modules\Residence\Infrastructure\Database\Seeders\TypeSeeder::class => [],
        \Modules\Residence\Infrastructure\Database\Seeders\FeatureSeeder::class => [],
        \Modules\Residence\Infrastructure\Database\Seeders\ResidenceSeeder::class => ['count' => 30],
        \Modules\Reservation\Infrastructure\Database\Seeders\ReservationSeeder::class => ['count' => 100],
    ];

    /**
     * @var array<string,array<int,mixed>>
     */
    private array $store = [];

    public function run(): void
    {
        Arr::map(array: self::SEEDERS, callback: function (array $dependencies, string $seeder): void {
            (new TwoColumnDetail(output: $this->command->getOutput()))
                ->render(first: $seeder, second: '<fg=yellow;options=bold>RUNNING</>');

            $startTime = microtime(as_float: true);
            $results = App::call(
                callback: [resolve(name: $seeder), 'run'],
                parameters: [...$this->store, ...$dependencies, 'persiste' => static::PERSISTE]
            );

            $runTime = number_format(num: (microtime(as_float: true) - $startTime) * 1000, decimals: 2);

            (new TwoColumnDetail(output: $this->command->getOutput()))
                ->render(first: $seeder, second: "<fg=gray>{$runTime} ms</> <fg=green;options=bold>DONE</>");

            $this->command->getOutput()->writeln(messages: '');

            if (\is_array(value: $results)) {
                $this->store = array_merge($this->store, $results);
            }
        });
    }
}
