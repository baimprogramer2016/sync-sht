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
        Schema::create('synchronize', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('command')->nullable();
            $table->text('query')->nullable();
            $table->text('limit_record')->nullable();
            $table->string('source_connection')->nullable();
            $table->string('target_connection')->nullable();
            $table->string('target_table')->nullable();
            $table->integer('active')->nullable();
            $table->integer('record')->nullable();
            $table->string('cron')->nullable();
            $table->text('additional_query')->nullable();
            $table->string('error_message')->nullable();
            $table->integer('target_truncate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('synchronize');
    }
};
