<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use Validator;
class WiGSV extends Controller
{
    //
	public function __construct()
	{

		$this->middleware('auth');
	}
	public function index(Request $request)
	{
		setlocale(LC_ALL,"");
		$date = strftime("%A %d %B %G", strtotime(Date('Y-m-d')));
		$device = Cookie::get('device');
		return view('pages.home',["DEVICE"=>$device,"TITLE"=> "Accueill Wicom GSV","DATE"=>$date]);
	}
	public function addEl(Request $r){


		$obj = \App\Objet::where('ref',$r->objet)->first();
		$fact = \App\Facture::where('ref',$r->ref)->first();
		if($r->client != $fact->id_client)
			\App\Facture::where('ref',$r->ref)->update(['id_client'=>$r->client]);
		$obj_fact = \App\Obj_Facture::where('id_facture',$fact->id_facture)->where('id_objet',$obj->id_objet)->first();

		if($obj_fact == null){
			
			$obj_fact= new \App\Obj_Facture();
			$obj_fact->id_facture = $fact->id_facture;
			$obj_fact->id_objet = $obj->id_objet;
			$obj_fact->reduction = $r->reduction;
			$obj_fact->qte = $r->qte;
			$obj_fact->save();
			$obj_fact = \App\Obj_Facture::orderBy('id_objFacture','desc')->first();
			$fact->updateM();
			return redirect()->route('factures',['AjouterFacture']);
		}else{

			
			\App\Obj_Facture::where('id_objFacture',$obj_fact->id_objFacture)->update(["qte"=>$r->qte , "reduction"=>$r->reduction]);
			$fact->updateM();
			return redirect()->route('factures',['AjouterFacture']);


		}

	}
	public function delEl(Request $r,$id){
		\App\Obj_Facture::where('id_objFacture',$id)->first()->delete();
		return back();
	}
/*
*	Facture Models
*/
public function facturesM(Request $r){
	setlocale(LC_ALL,"");
	$device = Cookie::get('device');
	$date = strftime("%A %d %B %G", strtotime(date('Y-m-d')));
	return view('pages.Mfactures',["DEVICE"=>$device,'TITLE'=> "Factures Models","DATE"=>$date]);
}
/*
 AJOUTER MODEL 
*/
 public function addModel(Request $r){

 	if($r->nom != null && $r->ref != null){
 		$model = new \App\Composer();
 		if($r->image != null){
 			$r->validate([]);
 			$validator = Validator::make($r->all(), [
 				'image' => 'required|image|mimes:jpeg,png,jpg|max:4096'
 			]);
 			if ($validator->fails()) {
 				$r->session()->flash("danger",$r->nom." Veuiller entre une image valide");
 				return redirect()->action('WiGSV@models');
 			}
 			$image = $r->file('image');
 			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
 			$destinationPath = public_path('/img');
 			$image->move($destinationPath, $input['imagename']);
 			$model->image = $input['imagename'];
 		}

 		$model->nom = $r->nom;
 		$model->ref = $r->ref;
 		$model->bonus = "1";
 		$model->description = ($r->description == null ? "" : $r->description);

 		if($model->save())
 			$r->session()->flash("success",$r->nom." Ajouter avec success");

 	}

 	return redirect()->route('modelObj',['id'=>\App\Composer::orderby('id_model','desc')->first()->id_model]);
 }
/*
 PROFILE MODEL 
*/
 public function modelObj(Request $r,$id){
 	$MODEL = \App\Composer::where('id_model',$id)->first();
 	if($MODEL == null )
 		return abort('404');
 	$kits = $MODEL->getKits();
 	setlocale(LC_ALL,"");
 	$date = strftime("%A %d %B %G", strtotime(Date('Y-m-d')));
 	$device = Cookie::get('device');
 	return view('pages.modelObj',["DEVICE"=>$device,'TITLE'=> "Model ".$MODEL->nom,"DATE"=>$date,"MODEL"=>$MODEL,"KITS"=>$kits]);
 }
/*
 MODIFIER MODEL 
*/
 public function upModel(Request $r){
 	if($r->nom != null && $r->ref != null ){
 		$a = false;
 		if($r->image != null){
 			$r->validate([]);
 			$validator = Validator::make($r->all(), [
 				'image' => 'required|image|mimes:jpeg,png,jpg|max:4096'
 			]);
 			if ($validator->fails()) {
 				$r->session()->flash("danger",$r->nom." Veuiller entre une image valide");
 				return back();
 			}
 			$image = $r->file('image');
 			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
 			$destinationPath = public_path('/img');
 			$image->move($destinationPath, $input['imagename']);
 			$a = true;
 			$model = \App\Composer::where('id_model',$r->id)->first();
 			unlink(public_path('/img')."/".$model->image);
 		}
 		$toUpdate = array(
 			'nom' => $r->nom,
 			'ref' => $r->ref,
 			'bonus' => $r->bonus,
 			'description' => $r->description
 		);
 		if($a)
 			$toUpdate = array_merge($toUpdate,['image'=>$input['imagename']]);

 		$model = \App\Composer::where('id_model',$r->id)->update($toUpdate);
 		if(is_array($r->id_obj)){
 			for ($i=0; $i < count($r->id_obj); $i++) { 
 				$kit = \App\Modelskit::where('id_objet',$r->id_obj[$i])->where('id_model',$r->id)->first();
 				if($kit == null){
 					$kit = new \App\Modelskit();
 					$kit->id_objet = $r->id_obj[$i];
 					$kit->id_model = $r->id;
 					$kit->F = $r->X[$i];

 					$kit->save();
 				} else{

 					$toUpdate = ["F"=>$r->X[$i]];
 					\App\Modelskit::where('id_kit',$kit->id_kit)->update($toUpdate);
 				}   
 			}}else if($r->id_obj != null){

 				if(\App\Modelskit::where('id_objet',$r->id_obj)->where('id_model',$r->id)->first() == null){
 					$kit = new \App\Modelskit();
 					$kit->id_objet = $r->id_obj;
 					$kit->id_model = $r->id;
 					$kit->F = $r->X[0];

 					$kit->save();
 				} else{
 					$kit = \App\Modelskit::where('id_objet',$r->id_obj)->where('id_model',$r->id)->first();
 					$toUpdate = ["F"=>$r->X[0]];
 					\App\Modelskit::where('id_kit',$kit->id_kit)->update($toUpdate);
 				}
 			}
 		}
 		if(is_array($r->formules)){
 			for ($i=0; $i < count($r->formules); $i++) { 
 				$cat = \App\ModelCategorie::where('id_model',$r->id)->where('categorie',$r->categories[$i])->first();
 				if($cat == null){
 					$cat = new \App\ModelCategorie();
 					$cat->id_model = $r->id;
 					$cat->formule = $r->formules[$i];
 					$cat->categorie = $r->categories[$i];
 					$cat->save();
 				}else{
 					\App\ModelCategorie::where('id_model',$r->id)->where('categorie',$r->categories[$i])->update(["formule" => $r->formules[$i]]);
 				}
 			}
 		}else{
 			if($r->categories != null){
 				$cat = \App\ModelCategorie::where('id_model',$model->id_model)->where('categorie',$r->categories)->first();
 				if($cat == null){
 					$cat = new \App\ModelCategorie();
 					$cat->id_model = $model->id_model;
 					$cat->formule = $r->formules;
 					$cat->categorie = $r->categories;
 					$cat->save();
 				}else{
 					\App\ModelCategorie::where('id_model',$model->id_model)->where('categorie',$r->categories)->update(["formule" => $r->formules]);
 				}
 			}
 		}
 		///suppression
 		
 		$CATEGORIES = \App\ModelCategorie::where('id_model',$r->id)->get();

 		foreach ($CATEGORIES as $C ) {
 			
 			if($r->categories == null){
 				\App\ModelCategorie::where("id_model",$r->id)->delete();
 			}
 			elseif(is_array($r->categories)){
 				$a = true ;
 				for($i = 0; $i < count($r->categories);$i++){
 					if($C->categorie == $r->categories[$i]){
 						$a = false;
 						break;
 					}
 				}
 				if($a){
 					\App\ModelCategorie::where("id_modelCategorie",$C->id_modelCategorie)->delete();
 				}
 			}else{
 				if($C->categorie == $r->categories){
 					\App\ModelCategorie::where("id_modelCategorie",$C->id_modelCategorie)->delete();
 				}
 			}
 		}
 		$r->session()->flash("success",$r->nom." Modifier avec success");
 		return redirect()->route('modelObj',['id'=>$r->id]);

 	}
/*
 SUPPRIMER MODEL 
*/		
 public function delModel(Request $r,$id){

 	if(\App\Composer::where('id_model',$id)->first() != null){
 		\App\Composer::where('id_model',$id)->update(["visible"=>0]);
 	}
 	return redirect()->route('models');
 }
/*
 PAGE FACTURES GET 
*/		
 public function factures(Request $r)
 {


 	$factures = \App\Facture::where('visible',1)->get();

 	setlocale(LC_ALL,"");
 	$date = strftime("%A %d %B %G", strtotime(Date('Y-m-d')));
 	$device = Cookie::get('device');

 	return view('pages.factures',["DEVICE"=>$device,'TITLE'=> "Factures","DATE"=>$date,"FACTURES"=>$factures]);
 }
/*
 PAGE MODELS GET 
*/		
 public function models(Request $r)
 {


 	setlocale(LC_ALL,"");
 	$device = Cookie::get('device');
 	$date = strftime("%A %d %B %G", strtotime(date('Y-m-d')));
 	return view("pages.models",["DEVICE"=>$device,"TITLE"=>"Models","DATE"=>$date]);
 }
/*
 PAGE STOCKS GET 
*/		
 public function stocks(Request $r)
 {


 	$objets = \App\Objet::where('visible',1)->get();
 	setlocale(LC_ALL,"");
 	$device = Cookie::get('device');
 	$date = strftime("%A %d %B %G", strtotime(date('Y-m-d')));
 	return view('pages.stocks',["DEVICE"=>$device,'TITLE'=> "Stocks","DATE"=>$date,"OBJETS"=>$objets]);
 }
/*
 ENSTOKER OBJETS  
*/
 public function enstocker(Request $r){


 	for($i = 0 ; $i < count($r->objet) ;$i++){
 		$objet = \App\Objet::where('ref',$r->objet[$i])->first();
 		$qte = $objet->enStock;
 		$qte += $r->qte[$i];
 		$objet = \App\Objet::where('ref',$r->objet[$i])->update(['enStock'=>$qte]);
 	}
 	return redirect()->action('WiGSV@stocks');
 }
/*
 AJOUTER OBJET 
*/
 public function addStocks(Request $r){


 	if($r->nom != null && $r->ref != null && $r->prix != null){
 		$objet = new \App\Objet();
 		if($r->image != null){
 			$r->validate([]);
 			$validator = Validator::make($r->all(), [
 				'image' => 'required|image|mimes:jpeg,png,jpg|max:4096'
 			]);
 			if ($validator->fails()) {
 				$r->session()->flash("danger",$r->nom." Veuiller entre une image valide");
 				return redirect()->action('WiGSV@stocks');
 			}
 			$image = $r->file('image');
 			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
 			$destinationPath = public_path('/img');
 			$image->move($destinationPath, $input['imagename']);
 			$objet->image = $input['imagename'];
 		}

 		$objet->nom = $r->nom;
 		$objet->ref = $r->ref;
 		$objet->prix = $r->prix;
 		$objet->categorie = strtoupper($r->categorie);
 		$objet->description = ($r->description == null ? "" : $r->description);
 		$objet->enStock = $r->enStock;
 		if($objet->save())
 			$r->session()->flash("success",$r->nom." Ajouter avec success");

 	}
 	return redirect()->action('WiGSV@stocks');
 }
/*
 PROFILE OBJET GET
*/
 public function objet(Request $r,$id,$name){


 	$objet = \App\Objet::where('id_objet',$id)->first(); 
 	setlocale(LC_ALL,"");
 	$device = Cookie::get('device');
 	$date = strftime("%A %d %B %G", strtotime(date('Y-m-d')));
 	return view('pages.objet',["DEVICE"=>$device,'TITLE' => $objet->nom ,"DATE" => $date , "OBJET"=>$objet]);
 }
/*
 MAJ OBJET 
*/
 public function upObjet(Request $r){


 	if($r->nom != null && $r->ref != null && $r->prix != null){
 		$a = false;
 		if($r->image != null){
 			$r->validate([]);
 			$validator = Validator::make($r->all(), [
 				'image' => 'required|image|mimes:jpeg,png,jpg|max:4096'
 			]);
 			if ($validator->fails()) {
 				$r->session()->flash("danger",$r->nom." Veuiller entre une image valide");
 				return redirect()->action('WiGSV@stocks');
 			}
 			$image = $r->file('image');
 			$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
 			$destinationPath = public_path('/img');
 			$image->move($destinationPath, $input['imagename']);
 			$a = true;
 			$obj = \App\Objet::where('id_objet',$r->id)->first();
 			unlink(public_path('/img')."/".$obj->image);
 		}
 		$toUpdate = array(
 			'nom' => $r->nom,
 			'ref' => $r->ref,
 			'prix' => $r->prix,
 			'categorie' => strtoupper($r->categorie),
 			'description' => $r->description
 		);
 		if($a)
 			$toUpdate = array_merge($toUpdate,['image'=>$input['imagename']]);

 		$objet = \App\Objet::where('id_objet',$r->id)->update($toUpdate);


 		$r->session()->flash("success",$r->nom." Modifier avec success");
 	}
 	return redirect()->action('WiGSV@stocks');
 }
/*
 SUPPRIMER OBJET 
*/
 public function delObjet(Request $r,$id){


 	$objet = \App\Objet::where("id_objet",$id)->first();
 	if($objet != null){
 		\App\Objet::where('id_objet',$id)->update(['visible'=>0]);

 		$r->session()->flash('warning',$objet->nom.' supprimer avec success');
 	}
 	return redirect()->action('WiGSV@stocks');
 }
/*
 PAGE CLIENTS GET 
*/
 public function clients(Request $r)
 {


 	$clients = \App\Client::where('visible',1)->get(); 
 	setlocale(LC_ALL,"");
 	$device = Cookie::get('device');
 	$date = strftime("%A %d %B %G", strtotime(date('Y-m-d')));
 	return view('pages.clients',["DEVICE"=>$device,'TITLE' => 'Clients',"DATE" => $date , "CLIENTS"=>$clients]);
 }
/*
 PROFILE CLIENT GET 
*/
 public function client(Request $r,$id , $name){


 	$client = \App\Client::where("id_client",$id)->first();
 	$device = Cookie::get('device');
 	setlocale(LC_ALL, "");
 	$date = strftime("%A %d %B %Y", strtotime(date('Y-m-d')));
 	return view('pages.client',["DEVICE"=>$device,'TITLE' => 'Clients',"DATE" => $date ,'CLIENT' => $client]);
 }
/*
 AJOUTER CLIENT 
*/
 public function addClient(Request $r){


 	if($r->input('name') != null && $r->input('phone')!= null && $r->input('email') != null && $r->input('addr') != null ){
 		$client = new \App\Client();
 		$client->name = $r->name;
 		$client->tel = $r->phone;
 		$client->adress = $r->addr;
 		$client->typeCompte = $r->typeC;
 		$client->email = $r->email;
 		$client->rc = $r->typeC ? $r->RC : "";
 		if($client->save()){
 			$r->session()->flash('success',$r->name.' ajouter avec success');
 			return redirect()->action('WiGSV@clients');

 		}
 	}else{
 		return redirect()->action('WiGSV@clients');

 	}
 }
/*
 MAJ CLIENT 
*/
 public function upClient(Request $r){


 	if($r->input('name') != null && $r->input('phone')!= null && $r->input('email') != null && $r->input('addr') != null ){
 		$client = \App\Client::where('id_client',$r->id)->first();
 		if($client == null)
 			return redirect()->action('WiGSV@clients');
 		$a = array(
 			'name' => $r->name,
 			'tel'=>$r->phone,
 			'adress'=>$r->addr,
 			'typeCompte'=>$r->typeC,
 			'email'=>$r->email,
 			'rc'=>$r->typeC ? $r->RC : ""
 		);
 		if(\App\Client::where('id_client',$r->id)->update($a)){
 			$r->session()->flash('success',$r->name.' modifier avec success');
 			return redirect()->action('WiGSV@clients');
 		}
 	}else{
 		return redirect()->action('WiGSV@clients');

 	}
 }
/*
 SUPPRIMER CLIENT 
*/

 public function delClient(Request $r,$id){


 	$client = \App\Client::where("id_client",$id)->first();
 	if($client != null){
 		\App\Client::where('id_client',$id)->update(['visible'=>0]);

 		$r->session()->flash('warning',$client->name.' supprimer avec success');
 	}
 	return redirect()->action('WiGSV@clients');

 }
}
