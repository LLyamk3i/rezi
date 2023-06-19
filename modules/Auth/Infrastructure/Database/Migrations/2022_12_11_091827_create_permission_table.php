<?php

declare(strict_types=1);

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
        Schema::create(table: 'permissions', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();
            $table->string(column: 'name', length: 15);
            $table->string(column: 'guard', length: 5)->default(value: config(key: 'auth.defaults.guard'));
            $table->timestamps();
            $table->unique(columns: ['name', 'guard']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('permissions');
    }
};
