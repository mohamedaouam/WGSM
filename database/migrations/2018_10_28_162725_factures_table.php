<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  
        if(!Schema::hastable("factures"))

            Schema::create('factures', function (Blueprint $table) {
                $table->increments('id_facture');
                $table->string('ref')->unique();
                $table->boolean('valider')->default(false);
                $table->boolean('payer')->default(false);
                $table->boolean('livre')->default(false);
                $table->string('montant');
                $table->integer('reduction')->default(0);
                $table->unsignedInteger('id_client');
                $table->unsignedInteger('id_user');
                $table->boolean('visible')->default(true);

                $table->rememberToken();
                $table->timestamps();

                $table->foreign('id_user')->references('id')->on('users');
                $table->foreign('id_client')->references('id_client')->on('clients');
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
