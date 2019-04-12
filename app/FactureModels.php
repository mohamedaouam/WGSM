<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactureModels extends Model
{
    //
	protected $fillable =["id_facture","id_objet","id_client"];
	protected $primaryKey = "id_facture";
	protected $table = "facturesmodels";
	/***
	*	STATIC
	***/
	public static function GEN(){
		$from = date('Y')."-01-01";
		$date = \DateTime::createFromFormat('Y-m-d',date('Y-m-d') );
		$date->modify('+1 day');
		$to = $date->format('Y-m-d');
		$ref = "F/". date('Y')."/".str_pad((\App\FactureModels::whereBetween('created_at',[$from , $to])->count() + 1), 3, '0', STR_PAD_LEFT) ;
		return $ref;
	}

	public function getClient(){
		return \App\Client::where('id_client',$this->id_client)->first();
	}
}
