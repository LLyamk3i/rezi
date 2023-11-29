<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Modules\Payment\Domain\Enums\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Shared\Infrastructure\Supports\Enum;

return new class extends Migration
{
    /**
     * @throws \RuntimeException
     */
    public function up(): void
    {
        Enum::api(enum: Status::class);

        Schema::create(table: 'payments', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();
            $table->integer(column: 'amount', unsigned: true);
            $table->enum(column: 'status', allowed: Enum::values());
            $table->timestamp(column: 'payed_at')->nullable();

            $table->ulid(column: 'reservation_id')->nullable();
            $table->ulid(column: 'user_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * @throws \RuntimeException
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'payments');
    }
};
