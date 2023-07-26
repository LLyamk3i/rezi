<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();

            $table->string(column: 'fileable_type', length: 4);
            $table->ulid(column: 'fileable_id');
            $table->string(column: 'name', length: 100)->nullable();
            $table->string(column: 'path', length: 100);
            $table->string(column: 'type', length: 50)->nullable();

            $table->timestamps();

            $table->index(columns: ['fileable_type', 'fileable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
