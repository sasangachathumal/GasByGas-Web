<?php

use App\RequestType;
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
        Schema::create('requests', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('gas_id')->constrained('gases')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('type', array_column(RequestType::cases(), 'value'))->default(RequestType::Consumer->value);
            $table->string('token');
            $table->integer('quantity');
            $table->date('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
