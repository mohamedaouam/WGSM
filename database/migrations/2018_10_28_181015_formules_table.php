<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FormulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hastable("formules"))

         Schema::create('formules', function (Blueprint $table) {
            $table->increments('id_formules');
            $table->string('text');
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
