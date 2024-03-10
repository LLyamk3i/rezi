<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'notifications', callback: static function (Blueprint $table): void {
            $table->uuid(column: 'id')->primary();
            $table->string(column: 'type');
            $table->morphs(name: 'notifiable');
            $table->text(column: 'data');
            $table->timestamp(column: 'read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'notifications');
    }
};
