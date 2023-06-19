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
        Schema::create(table: 'permission_role', callback: static function (Blueprint $table): void {
            $table->foreignUlid(column: 'permission_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid(column: 'role_id')->constrained()->cascadeOnDelete();
            $table->primary(columns: ['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'permission_role');
    }
};
