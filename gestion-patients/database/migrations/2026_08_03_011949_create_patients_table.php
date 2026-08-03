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
    Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('prenom');
        $table->string('telephone');
        $table->string('numero_cmu')->nullable();
        $table->boolean('a_assurance')->default(false);
        $table->string('numero_assurance')->nullable();
        $table->date('date_naissance')->nullable();
        $table->enum('sexe', ['M', 'F'])->nullable();
        $table->string('adresse')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
