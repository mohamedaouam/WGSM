<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasTable("models"))
            Schema::create('models', function (Blueprint $table) {
                $table->increments('id_model');
                $table->string('ref')->unique();
                $table->integer('bonus')->default(0);
                $table->string('height');
                $table->string('width');
                $table->string('nom');
                $table->string('description')->default('');
                $table->boolean('visible')->default(true);
                $table->rememberToken();
                $table->timestamps();

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
