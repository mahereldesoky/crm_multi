<?php

use App\Models\Configuration;
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
        Schema::table('configurations', function (Blueprint $table) {
            Configuration::create([
                'config' => 'setup_complete',
                'value' => 0,
            ]);
            Configuration::create([
                'config' => 'setup_stage',
                'value' => 1,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configurations', function (Blueprint $table) {
            //
        });
    }
};
