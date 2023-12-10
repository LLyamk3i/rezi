<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * @throws \RuntimeException
     */
    public function up(): void
    {
        Schema::create(table: 'views', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();
            $table->ulid(column: 'device');
            $table->ulid(column: 'residence_id');
            $table->unique(columns: ['device', 'residence_id']);
            $table->timestamps();
        });
    }

    /**
     * @throws \RuntimeException
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'views');
    }
};
