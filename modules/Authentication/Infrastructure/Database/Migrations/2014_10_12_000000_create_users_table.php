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
        Schema::create(table: 'users', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'id')->primary();
            $table->string(column: 'forename');
            $table->string(column: 'surname');
            $table->string(column: 'phone');
            $table->string(column: 'address')->nullable();
            $table->string(column: 'emergency_contact')->nullable();
            $table->string(column: 'email')->unique();
            $table->timestamp(column: 'email_verified_at')->nullable();
            $table->string(column: 'password');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * @throws RuntimeException
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'users');
    }
};
