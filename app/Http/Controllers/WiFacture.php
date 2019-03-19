<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use Validator;

class WiFacture extends Controller
{
    //
	public function __construct()
	{

		$this->middleware('auth');
	}
	public function newFM(Request $r){
		setlocale(LC_ALL,"");
		$date = strftime("%A %d %B %G", strtotime(Date('Y-m-d')));
		$device = Cookie::get('device');
		return view('pages.factures.models',["DEVICE"=>$device,"TITLE"=> "Nouvelle facture des models","DATE"=>$date]);
	}
	public function getmodeldata(Request $r ){
		$model = \App\Composer::where('id_model',$r->input('id'))->first();
		$kits = $model->getKits();
		$categories = array();
		foreach($model->getCategories() as $cat){
			array_push($categories, $cat->categorie);
		}
		$ReSponse = array(
			"MODEL" => $model,
			"KITS" => $kits,
			"CATEGORIES" => $categories
		) ;
		return response($ReSponse);
	}
	public function getobjetbycat(Request $r){
		$objet = \App\Objet::where('categorie',$r->input('cat'))->get();
		return response($objet);
	}
}
