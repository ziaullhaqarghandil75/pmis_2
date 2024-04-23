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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('img')->nullable();

            $table->unsignedBigInteger('department_id');
            // $table->foreign('department_id')->references('id')->on('departments')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');

            $table->unsignedBigInteger('role_id');
            // $table->foreign('role_id')->references('id')->on('roles')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');

            $table->enum('status', [0, 1]);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
