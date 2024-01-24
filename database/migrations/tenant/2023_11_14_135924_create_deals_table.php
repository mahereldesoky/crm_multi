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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('customer_id');
            $table->bigInteger('account_id');
            $table->bigInteger('compaign_id');
            $table->string('name');
            $table->string('type');
            $table->string('lead_src');
            $table->dateTime('closedate')->nullable()->default(now());
            $table->integer('stage_id');
            $table->string('amount');
            $table->string('probability');
            $table->string('description');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
