<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * @throws RuntimeException
     */
    public function up(): void
    {
        Schema::create(table: 'features', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();
            $table->string(column: 'name', length: 100);
            $table->timestamps();
        });
    }

    /**
     * @throws RuntimeException
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'features');
    }
};
