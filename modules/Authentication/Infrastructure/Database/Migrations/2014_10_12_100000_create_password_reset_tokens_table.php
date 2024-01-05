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
        Schema::create(table: 'password_reset_tokens', callback: static function (Blueprint $table): void {
            $table->string(column: 'email')->primary();
            $table->string(column: 'token');
            $table->timestamp(column: 'created_at')->nullable();
        });
    }

    /**
     * @throws RuntimeException
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'password_reset_tokens');
    }
};
