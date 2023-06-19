<?php

declare(strict_types=1);

use Modules\Auth\Domain\Enums\Roles;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
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
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'roles');
    }
};
