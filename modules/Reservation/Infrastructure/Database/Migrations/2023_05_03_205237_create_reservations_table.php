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
            $table->dateTime(column: 'checkin_at');
            $table->dateTime(column: 'checkout_at');
            $table->ulid(column: 'user_id');
            $table->ulid(column: 'residence_id');
            $table->enum(column: 'status', allowed: Status::values());
            $table->integer(column: 'cost', unsigned: true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'reservations');
    }
};
