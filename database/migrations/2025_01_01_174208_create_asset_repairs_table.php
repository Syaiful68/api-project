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
        Schema::create('asset_repairs', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id');
            $table->string('description');
            $table->string('handle')->nullable();
            $table->string('user_id');
            $table->enum('status', ['request', 'complete', 'repair'])->default('request');
            $table->string('user_handle')->nullable();
            $table->softDeletes('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_repairs');
    }
};
