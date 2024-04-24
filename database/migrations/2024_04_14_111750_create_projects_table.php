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
            $table->BigInteger('length')->nullable();
            $table->BigInteger('width')->nullable();
            $table->BigInteger('number')->nullable();

            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('unit_id')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('impliment_department_id');
            $table->foreign('impliment_department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('management_department_id');
            $table->foreign('management_department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('design_department_id');
            $table->foreign('design_department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->enum('project_type', [0, 1]);
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
