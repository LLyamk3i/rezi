<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table: 'role_user', callback: static function (Blueprint $table): void {
            $table->foreignUlid(column: 'user_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid(column: 'role_id')->constrained()->cascadeOnDelete();
            $table->timestamp(column: 'created_at')->useCurrent();
            $table->primary(columns: ['role_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'role_user');
    }
};
