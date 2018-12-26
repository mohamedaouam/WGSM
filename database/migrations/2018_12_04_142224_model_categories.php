<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModelCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasTable("modelCategories"))
            Schema::create('modelCategories', function (Blueprint $table) {
                $table->increments('id_modelCategorie');
                $table->string('formule')->default("1");
                $table->string('categorie');
                $table->unsignedInteger('id_model');
                $table->timestamps();
                $table->foreign('id_model')->references('id_model')->on('models');

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
