<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Facture extends Model
{
    //
	protected $fillable =["id_facture","id_objet","id_client"];
	protected $primaryKey = "id_facture";
	public function updateM(){
		$objs = \App\Obj_Facture::where('id_facture',$this->id_facture)->get();
		$this->montant = 0;
		foreach($objs as $obj){
			$this->montant += ($obj->prix() * $obj->qte);
		}
		$this->save();
	}
	public static function currentFacture($type){
		$f = \App\Facture::where('type',$type)->orderBy('id_facture','desc')->first();
		if($f == null){
			return Facture::NvFacture($type);
		}
		if($f->valider )
			return Facture::NvFacture($type);
		return $f->ref;
	}
	public static function NvFacture($type){
		$from = date('Y')."-01-01";
		$date = \DateTime::createFromFormat('Y-m-d',date('Y-m-d') );
		$date->modify('+1 day');
		$to = $date->format('Y-m-d');
		$F = new \App\Facture();
		$F->ref = str_pad((\App\Facture::whereBetween('created_at',[$from , $to])->count() + 1), 3, '0', STR_PAD_LEFT) ."/". date('Y');
		$ref = $F->ref;
		$F->id_client = 1;
		$F->id_user = Auth::user()->id;
		$F->montant = 0;
		$F->type = $type;
		$F->save();
		return $ref;
	}
	public function getClientName(){
		return \App\Client::where('id_client',$this->id_client)->first()->name;
	}
	public static function getID($ref){
		return \App\Facture::where('ref',$ref)->first()->id_facture;
	}
	public static function client($ref){
		return \App\Facture::where('ref',$ref)->first()->id_client;
	}
}
