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
            $table->id();
            $table->string("jobs_id")->nullable(); // une relation one to one est requise a ce niveau
            $table->string("city_id")->nullable(); // une relation one to one est requise
            $table->string('email')->unique();
            $table->string('name');
            $table->string("second_name")->nullable();
            $table->string("birth_date")->nullable();
            $table->string("adresse")->nullable();
            $table->string('telephone')->nullable();
            $table->string('fonction')->nullable();
            $table->string('grade')->nullable();
            $table->string('nature_piece')->nullable();
            $table->string('numero_piece')->nullable();
            $table->string('retraite')->nullable();
            $table->string('secteur_activite')->nullable();
            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
