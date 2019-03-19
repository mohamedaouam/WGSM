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
		$cats = null;
		$cats = \App\ModelCategorie::select('categorie')->where('id_model',$this->id_model)->get();
		$data = array();
		foreach (\App\Objet::select('categorie')->where('visible',"1")->distinct()->get() as $kit ) {
			if(is_array($cats)){
				if(!in_array($kit, $cats)){
					array_push($data, $kit);
				}
			}else{
				array_push($data, $kit);
			}
		}
		return $data;
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
