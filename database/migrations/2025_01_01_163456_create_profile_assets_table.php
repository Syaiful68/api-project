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
        Schema::create('profile_assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id');
            $table->string('pic');
            $table->string('location');
            $table->string('user_id');
            $table->enum('status', ['active', 'migrate'])->default('active');
            $table->softDeletes('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_assets');
    }
};
