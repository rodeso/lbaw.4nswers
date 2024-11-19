<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY
            $table->text('body')->check('LENGTH(body) <= 4096')->notNullable(); // Limit body length
            $table->timestamp('time_stamp')->default(DB::raw('CURRENT_TIMESTAMP'))->notNullable();
            $table->boolean('deleted')->default(false);
            $table->boolean('edited')->default(false);
            $table->timestamp('edit_time')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
