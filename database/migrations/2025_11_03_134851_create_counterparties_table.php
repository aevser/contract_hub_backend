<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Контрагенты
        Schema::create('counterparties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('inn')->unique();
            $table->string('name')->nullable();
            $table->string('ogrn')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            // Индексация
            $table->index(['user_id', 'inn']);
        });

        // Статусы логов
        Schema::create('counterparty_log_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('counterparty_log_statuses')->insert([
            [
                'name' => 'Ошибка',
                'type' => 'error',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Завершено',
                'type' => 'completed',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Логирование
        Schema::create('counterparty_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counterpart_id')->nullable()->constrained('counterparties')->cascadeOnDelete();
            $table->foreignId('status_id')->constrained('counterparty_log_statuses')->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->timestamps();

            // Индексация
            $table->index(['counterpart_id', 'status_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counterparty_logs');
        Schema::dropIfExists('counterparty_log_statuses');
        Schema::dropIfExists('counterparties');
    }
};
