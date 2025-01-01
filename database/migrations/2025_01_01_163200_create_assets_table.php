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
        Schema::create('tb_assets', function (Blueprint $table) {
            $table->id();
            $table->string('tags');
            $table->string('code_assets');
            $table->string('items');
            $table->enum('status', ['used', 'repair', 'destroy'])->default('used');
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_assets');
    }
};
