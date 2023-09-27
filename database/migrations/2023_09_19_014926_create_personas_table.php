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
        Schema::create('personas', function (Blueprint $table) {
            $table->id(); // id, bigInt, PK, AI, unsigned
            $table->string("nombres", 30);
            $table->string("apellidos", 50)->nullable();
            $table->string("ci_nit")->nullable();
            $table->date("fecha_nacimiento")->nullable();
            $table->bigInteger("user_id")->unsigned();
            // N:1
            $table->foreign("user_id")->references("id")->on("users");
            
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
