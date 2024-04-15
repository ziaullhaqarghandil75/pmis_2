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
        Schema::create('projects', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->unsignedBigInteger('gole_id');
            $table->foreign('gole_id')->references('id')->on('goals')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('name');
            $table->unsignedBigInteger('dimension_id');
            $table->foreign('dimension_id')->references('id')->on('type_dimensions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('dimension_value');
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')->references('id')->on('districts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->enum('transitional', [0, 1]);
            $table->enum('status', [0, 1]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
