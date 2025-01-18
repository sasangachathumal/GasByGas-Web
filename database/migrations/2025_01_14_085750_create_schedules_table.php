<?php

use App\StatusType;
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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('outlet_id')->constrained('outlets')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status', array_column(StatusType::cases(), 'value'))->default(StatusType::Pending->value);
            $table->date('schedule_date');
            $table->integer('max_quantity');
            $table->integer('available_quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
