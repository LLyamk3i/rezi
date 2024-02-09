<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use function Modules\Shared\Infrastructure\Helpers\string_value;

return new class extends Migration
{
    /**
     * @throws RuntimeException
     */
    public function up(): void
    {
        Schema::create('media', static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();

            $table->string(column: 'fileable_type', length: 4);
            $table->ulid(column: 'fileable_id');
            $table->string(column: 'name', length: 100)->nullable();
            $table->string(column: 'original')->unique();
            $table->string(column: 'path', length: 255);
            $table->string(column: 'type', length: 50)->nullable();
            $table->string(column: 'mime');
            $table->string(column: 'collection');
            $table->string(column: 'disk')->default(value: string_value(value: config(key: 'app.upload.disk')));
            $table->string(column: 'hash', length: 128);
            $table->unsignedBigInteger(column: 'size');

            $table->timestamps();

            $table->index(columns: ['fileable_type', 'fileable_id']);
        });
    }

    /**
     * @throws RuntimeException
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
