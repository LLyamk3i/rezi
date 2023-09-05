<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

final class SetupApplicationCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * @var string
     */
    protected $description = 'Set up the application';

    public function handle(): int
    {
        exec(command: 'unlink ./public/dist');

        $this->call(command: 'migrate:fresh');
        $this->call(command: 'admin:build');
        $this->call(command: 'db:seed');

        exec(command: 'ln -s $(readlink -f ./modules/Admin/resources/frontend/build) $(readlink -f ./public/dist)');

        $this->info(string: 'Your app is up');

        return Command::SUCCESS;
    }
}
