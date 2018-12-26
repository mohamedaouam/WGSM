<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelskit extends Model
{
    //
	public function getRef(){
		return \App\Objet::where('id_objet',$this->id_objet)->first()->ref;
	}
	public function getCategorie(){
		return \App\Objet::where('id_objet',$this->id_objet)->first()->categorie;
	}
}
