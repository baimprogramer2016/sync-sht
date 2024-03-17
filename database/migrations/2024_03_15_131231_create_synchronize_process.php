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
        Schema::create('synchronize_process', function (Blueprint $table) {
            $table->id();
            $table->string('code_synchronize')->nullable();
            $table->string('status')->nullable();
            $table->string('batchno')->nullable();
            $table->timestamp('start_date')->useCurrent()->nullable();
            $table->timestamp('end_date')->useCurrent()->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('synchronize_process');
    }
};
