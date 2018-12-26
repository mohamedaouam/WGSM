<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Composer extends Model
{
    //
	protected $table = 'models';
	public function iHaveIt($id){
		$kit = \App\Modelskit::where('id_objet',$id)->where('id_model',$this->id_model)->first();
		if($kit == null)
			return false;
		return true;
	}
	public function getAvailableCategories(){
		$data = array();
		foreach ($this->getKits() as $kit ) {
			array_push($data, $kit->getCategorie());
		}
		return \App\Objet::select('categorie')->where('visible',"1")->whereNotIn('categorie',$data)->distinct()->get();
	}
	public function getKitsObjetID(){
		$kits = $this->getKits();
		if($kits != null){
			$a = array();
			foreach($kits as $kit){
				array_push($a, $kit->id_objet);
			}
			return $a;
		}
		return null;

	}
	public function getCategories(){
		return \App\ModelCategorie::where('id_model',$this->id_model)->get();
	}
	public function getKits(){
		$kits = \App\Modelskit::where('id_model',$this->id_model)->get();
		return $kits;
	}
}
