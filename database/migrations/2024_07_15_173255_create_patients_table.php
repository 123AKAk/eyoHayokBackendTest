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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('card_no_id')->unique();
            $table->string('email')->unique();
            $table->string('phone_no');
            $table->string('marital_status');
            $table->date('date_of_birth');
            $table->integer('age');
            $table->string('nationality');
            $table->string('country');
            $table->string('city_town');
            $table->string('address');
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_phone_no')->nullable();
            $table->string('relationship')->nullable();
            $table->string('next_of_kin_email_address')->nullable();
            $table->string('next_of_kin_address')->nullable();
            $table->foreignId('added_by_Id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
