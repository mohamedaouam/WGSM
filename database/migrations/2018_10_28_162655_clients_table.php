<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hastable("clients"))

            Schema::create('clients', function (Blueprint $table) {
                $table->increments('id_client');
                $table->string('name');
                $table->string('adress');
                $table->string('tel');
                $table->string('rc');
                $table->string('typeCompte');
                $table->string('email')->unique();
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
