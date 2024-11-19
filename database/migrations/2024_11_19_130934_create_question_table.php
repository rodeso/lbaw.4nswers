<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY
            $table->text('title')->notNullable(); // Question title
            $table->string('urgency')->notNullable(); // Urgency level
            $table->timestamp('time_end')->notNullable(); // End time
            $table->boolean('closed')->default(false); // Is question closed?
            $table->foreignId('author_id')->constrained('user')->onDelete('cascade'); // References user
            $table->foreignId('post_id')->constrained('post')->onDelete('cascade'); // References post
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question');
    }
};
