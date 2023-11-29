<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Authentication\Domain\Enums\Roles;

return new class extends Migration
{
    /**
     * @throws \RuntimeException
     */
    public function up(): void
    {
        Schema::create(table: 'roles', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();
            $table->enum(column: 'name', allowed: Roles::values());
            $table->string(column: 'guard', length: 5)->default(value: 'web');
            $table->timestamps();
            $table->unique(columns: ['name', 'guard']);
        });
    }

    /**
     * @throws \RuntimeException
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'roles');
    }
};
