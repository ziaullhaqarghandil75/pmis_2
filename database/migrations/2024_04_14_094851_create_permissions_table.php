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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name');
            $table->string('description');
            
            $table->unsignedBigInteger('permission_gategory_id');
            $table->foreign('permission_gategory_id')->references('id')->on('permission_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->enum('status', [0, 1]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};