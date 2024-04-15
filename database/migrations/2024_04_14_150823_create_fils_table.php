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
        Schema::create('fils', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');

            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fils');
    }
};
