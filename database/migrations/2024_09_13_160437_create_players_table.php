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
     Schema::create('players', function (Blueprint $table) {
            $table->id(); // Creates an unsignedBigInteger 'id'
            $table->string('name');
            $table->unsignedBigInteger("number");
            $table->unsignedBigInteger("birthYear");
            $table->unsignedBigInteger('team_id'); // Ensure this matches the 'id' type of 'planets'
            
            // Add foreign key constraint
            $table->foreign('team_id')
                  ->references('id')
                  ->on('teams')
                  ->onDelete('cascade'); // Optional: Cascade delete if a planet is deleted

            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
