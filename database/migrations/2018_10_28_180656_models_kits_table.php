<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModelsKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasTable("modelKits"))
            Schema::create('modelsKits', function (Blueprint $table) {
                $table->increments('id_kit');
                $table->unsignedInteger('id_model');
                $table->unsignedInteger('id_objet');
                $table->string('F',125);
                $table->boolean('visible')->default(true);
                $table->rememberToken();
                $table->timestamps();

                $table->foreign('id_model')->references('id_model')->on('models');
                $table->foreign('id_objet')->references('id_objet')->on('objets');

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
