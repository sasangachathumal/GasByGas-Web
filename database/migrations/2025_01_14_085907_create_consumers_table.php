<?php

use App\ConsumerType;
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
        Schema::create('consumers', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('request_id')->constrained('requests')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nic')->nullable();
            $table->string('email');
            $table->string('phone_no');
            $table->enum('type', array_column(ConsumerType::cases(), 'value'))->default(ConsumerType::Customer->value);
            $table->string('business_no')->nullable();
            $table->enum('status', array_column(StatusType::cases(), 'value'))->default(StatusType::Pending->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumers');
    }
};
