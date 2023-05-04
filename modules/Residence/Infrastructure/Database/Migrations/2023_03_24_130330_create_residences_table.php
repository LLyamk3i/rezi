<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'residences', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();
            $table->string(column: 'name');
            $table->float(column: 'rent', total: 10, places: 2, unsigned: true);
            $table->string(column: 'address')->nullable();
            $table->point(column: 'location');

            $table->timestamps();

            $table->spatialIndex(columns: 'location', name: 'geo_location_spatialindex');
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table): void {
            $table->dropSpatialIndex(index: 'geo_location_spatialindex');
        });
        Schema::dropIfExists(table: 'residences');
    }
};
