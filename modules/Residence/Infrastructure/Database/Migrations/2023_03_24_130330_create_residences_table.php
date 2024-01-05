<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use function Modules\Shared\Infrastructure\Helpers\can_use_spatial_index;

return new class extends Migration
{
    /**
     * @throws RuntimeException
     */
    public function up(): void
    {
        Schema::create(table: 'residences', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();
            $table->string(column: 'name');
            $table->integer(column: 'rent', unsigned: true);
            $table->string(column: 'address')->nullable();
            $table->string(column: 'description')->nullable();
            if (can_use_spatial_index()) {
                $table->point(column: 'location');
            }

            $table->smallInteger(column: 'rooms', unsigned: true);
            $table->boolean(column: 'visible')->default(value: false);

            $table->ulid(column: 'user_id');
            $table->ulid(column: 'type_id');

            $table->timestamps();

            if (can_use_spatial_index()) {
                $table->spatialIndex(columns: 'location', name: 'geo_location_spatial_index');
            }
        });
    }

    /**
     * @throws RuntimeException
     */
    public function down(): void
    {
        Schema::table('locations', static function (Blueprint $table): void {
            if (can_use_spatial_index()) {
                $table->dropSpatialIndex(index: 'geo_location_spatialindex');
            }
        });
        Schema::dropIfExists(table: 'residences');
    }
};
