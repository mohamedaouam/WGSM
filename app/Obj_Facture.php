<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obj_Facture extends Model
{
    //
	protected $table = 'obj_factures';
	protected $primaryKey = "id_objFacture";
	public function name(){
		$obj = \App\Objet::where('id_objet',$this->id_objet)->first();
		return $obj->name;
	}
	public function ref(){
		$obj = \App\Objet::where('id_objet',$this->id_objet)->first();
		return $obj->ref;
	}
	public function prix(){
		$obj = \App\Objet::where('id_objet',$this->id_objet)->first();
		return $obj->prix - ($this->reduction * $obj->prix / 100);
	}
}
