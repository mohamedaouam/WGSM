<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ObjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hastable("objets"))
            Schema::create('objets', function (Blueprint $table) {
                $table->increments('id_objet');
                $table->string('ref')->unique();
                $table->string('prix');
                $table->integer('enStock')->default(0);
                $table->string('nom');
                $table->string('image')->default('objet.png');
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
