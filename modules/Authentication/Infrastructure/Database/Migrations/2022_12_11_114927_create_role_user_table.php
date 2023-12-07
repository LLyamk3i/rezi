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
        Schema::create(table: 'role_user', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'user_id')->constrained()->cascadeOnDelete();
            $table->ulid(column: 'role_id')->constrained()->cascadeOnDelete();
            $table->timestamp(column: 'created_at')->useCurrent();
            $table->primary(columns: ['role_id', 'user_id']);
        });
    }

    /**
     * @throws \RuntimeException
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'role_user');
    }
};
