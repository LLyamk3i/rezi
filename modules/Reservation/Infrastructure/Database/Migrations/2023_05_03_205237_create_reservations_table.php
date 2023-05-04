<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\Reservation\Domain\Enums\Status;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'reservations', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();
            $table->timestamp(column: 'checkin_at');
            $table->timestamp(column: 'checkout_at');
            $table->ulid(column: 'user_id')->nullable();
            $table->ulid(column: 'residence_id')->nullable();
            $table->enum(column: 'status', allowed: Status::values());
            $table->float(column: 'cost', total: 10, places: 2, unsigned: true);

            $table->timestamps();

            $table->foreign(columns: ['user_id'])->references(columns: 'id')->on(table: 'users')->nullOnDelete();
            $table->foreign(columns: ['residence_id'])->references(columns: 'id')->on(table: 'residences')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'reservations');
    }
};
