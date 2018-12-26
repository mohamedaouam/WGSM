<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ObjFactures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasTable("obj_factures"))
            Schema::create('obj_factures', function (Blueprint $table) {
                $table->increments('id_objFacture');
                $table->integer('qte')->default(1);
                $table->string('reduction')->default("0");
                $table->unsignedInteger('id_objet');
                $table->unsignedInteger('id_facture');
                $table->timestamps();

                $table->foreign('id_facture')->references('id_facture')->on('factures');
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
