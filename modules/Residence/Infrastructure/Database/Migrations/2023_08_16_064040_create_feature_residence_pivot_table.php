<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'feature_residence', callback: static function (Blueprint $table): void {
            $table->ulid(column: 'residence_id');
            $table->ulid(column: 'feature_id');
            $table->timestamp(column: 'created_at')->useCurrent();

            $table->primary(columns: ['residence_id', 'feature_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'feature_residence');
    }
};
