@extends('default')

@section('stylesheet')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('plugin/datatable/DataTables/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('plugin/datatable/Buttons/css/buttons.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('plugin/select2/css/select2.css')}}">
<style>

.data-btn:before {
	font-family: "untitled-font-1";
}

.copy:before {
	content: '& ';
}

.pdf:before {
	content: '] ';
}

.exls:before {
	content: '? ';
}
#tEN th{
	text-align: center;
}

</style>
@endsection

@section('content')
<div class="col-11 mx-auto pt-3">
	<ul class="nav nav-tabs text-center mx-auto col-8" id="tabb">
		<li class="nav-item"><a class="nav-link active" data-toggle="tab"
			href="#ListFactures"><span class="icon icon-files-o"></span> List
		Factures</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab"
			href="#AjouterFacture"><span class="icon icon-file-text"></span>
		Ajouter un objet</a></li>
		
		

	</ul>
	<div
	class="tab-content col-8 mx-auto border py-2 border-top-0 rounded-bottom">
	<div class="tab-pane fade show active row" id="ListFactures"
	role="tabpanel" aria-labelledby="listFactures-tab">

	<div class="col-11 mx-auto">
		<table class="table table-striped table-hover" id="objetsTable">
			<thead>
				<tr>
					<th>ID</th>
					<th>Referance</th>
					<th>Client</th>
					<th>Montant</th>
					
					
				</tr>
			</thead>
			<tbody>
				@foreach(\App\Facture::where('visible',1)->orderBy('id_facture','DESC')->get() as $facture)
				<tr>
					<td>{{$facture->id_facture}}</td>
					<td><a href="javascript:void(0)" onclick="" >{{$facture->ref}}</a></td>
					<td><a href="javascript:void(0)" onclick="document.location.href='{{Route('client',['id'=>$facture->id_client,'name'=>$facture->getClientName()])}}';" > {{$facture->getClientName()}}</a></td>
					<td>{{$facture->montant}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<div class="tab-pane fade row" id="AjouterFacture" role="tabpanel"
aria-labelledby="ajouterObjet-tab">

<div class="col-11 mx-auto pb-3 mb-2 border-bottom" id="tEN">
	<div class="text-right row">
		<h3 class="col-6 text-left text-primary">{{\App\Facture::currentFacture(1)}}</h3>
		<button class="btn btn-primary mr-2"><span class="icon icon-new"></span>Nouvelle Facture</button>
		<button class="btn btn-primary"><span class="icon icon-print"></span> Imprimer</button>
	</div>

	<div class="form-group">
		<label for="client">Client :</label>
		<select onchange="changeClient()" name="client" id="client" class="form-control col-8 mx-auto">
			@foreach(\App\Client::where('visible',1)->get() as $client)
			<option value="{{$client->id_client}}" {{\App\Facture::client(\App\Facture::currentFacture(1)) == $client->id_client ? "selected" : ""}}>{{$client->name}}</option>
			@endforeach
		</select>

	</div>
	<div class="col-12 mx-auto row">
		<form action="{{Route('addEl')}}" method="POST" class="row" id="facture">
			<input type="hidden" name="client" value="{{\App\Facture::orderby('id_facture','desc')->where('visible',1)->where('type',1)->first()->id_client}}">
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="hidden" name="ref" value="{{\App\Facture::currentFacture(1)}}">
			<div class="form-group col-9">
				<label for="obj">Article : </label>
				<select name="objet" id="selectArticle" class="form-control">
					@foreach(\App\Objet::where('visible',1)->get() as $objet)
					<option value="{{$objet->ref}}">{{$objet->ref ." ". $objet->nom." ".$objet->description}}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group col-4">
				<label for="obj">Quantite : </label>
				<input type="number" id="qte" name="qte" value="1" class="form-control">
			</div>
			<div class="form-group col-4">
				<label for="obj">reduction : </label>
				<input type="number" name="reduction" value="0" id="reduction" step="0.1" class="form-control">
			</div>
			<div class="col-4 text-center">
				<button type="submit" class="btn btn-primary"><span class="icon icon-plus"></span> Ajouter</button>
			</div>
		</form>
	</div>
	<table class="table table-hover table-striped col-11 mx-auto">
		<thead>
			<tr>
				<th>
					REF
				</th>
				<th>
					ARTICLE
				</th>
				<th>
					QTE
				</th>
				<th>
					REDUCTION
				</th>
				<th>
					PRIX
				</th>
				<th>

				</th>
			</tr>
		</thead>
		<tbody id="objFacture" class="text-center">
			@foreach(\App\Obj_Facture::where('id_facture',\App\Facture::getID(\App\Facture::currentFacture(1)))->orderBy('id_objFacture','DESC')->get() as $obj)
			<tr>
				<td>
					{{$obj->ref()}}
				</td>
				<td>
					{{$obj->name()}}
				</td>
				<td>
					{{$obj->qte}}
				</td>
				<td>
					{{$obj->reduction}}
				</td>
				<td>
					{{$obj->prix()}}
				</td>
				<td>
					<a class="text-danger" href="javascript:void(0)" onclick="document.location.href='{{Route('delEl',['id'=>$obj->id_objFacture])}}';"><span class="icon icon-times"></span></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="row mt-2 border-top pt-2">
		<form class="col-12 row" action="">
			
			<input type="hidden">
			<div class=" col-3 custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" name="valider" id="valider">
				<label class="custom-control-label" for="valider" onclick="valider()" value="{{\App\Facture::where('ref',\App\Facture::currentFacture(1))->first()->valider}}">Valider</label>
			</div>
			<div class="col-3  custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" name="payer" id="payer" value="{{\App\Facture::where('ref',\App\Facture::currentFacture(1))->first()->payer}}">
				<label class="custom-control-label" for="payer">Payer</label>
			</div>
			<div class="col-3 custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" name="livre" id="livre" value="{{\App\Facture::where('ref',\App\Facture::currentFacture(1))->first()->livre}}">
				<label class="custom-control-label" for="livre">Livre</label>
			</div>
			<h5 class="col-3 text-danger">{{number_format(\App\Facture::where('ref',\App\Facture::currentFacture(1))->first()->montant, 2, ',', ' ')}} DZD</h5>
			<button type="button" class=" col-6 mx-auto  mt-2 text-center btn btn-primary" data-toggle="modal" data-target="#objets" ><span class="icon icon-plus"></span> Cloturer facture</button>			

		</form>
		<div class="form-group col-4">
		</div>
	</div>

</div>
</div>
</div>
</div>


@endsection

@section('scripts')

<script src="{{asset('plugin/datatable/DataTables/js/jquery.dataTables.js')}}"></script>
<script	src="{{asset('plugin/datatable/DataTables/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('plugin/datatable/Buttons/js/dataTables.buttons.js')}}"></script>
<script src="{{asset('plugin/datatable/Buttons/js/buttons.bootstrap4.js')}}"></script>
<script src="{{asset('plugin/datatable/JSZip/jszip.js')}}"></script>
<script src="{{asset('plugin/datatable/pdfmake/pdfmake.js')}}"></script>
<script src="{{asset('plugin/datatable/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugin/datatable/Buttons/js/buttons.html5.js')}}"></script>
<script src="{{asset('plugin/datatable/Buttons/js/buttons.print.js')}}"></script>
<script src="{{asset('js/dateTable.js')}}"></script>
<script src="{{asset('plugin/select2/js/select2.js')}}"></script>
<script>
	function changeClient(){
		c = $('#client option:selected').val();
		$('input[name=client]').attr('value',c);
	}
	function valider(){
		
		if($('#valider').val() == 'on'){
			$('#payer').removeAttr('disabled');
			$('#livre').removeAttr('disabled');
		}else{
			$('#payer').attr('disabled',"");
			$('#livre').attr('disabled',"");
		}
	}
	$(document).ready(function(){
		valider();
		col = [ { data : 'ID' }, {data : 'Referance'} , {data: 'nom'} , {data: 'Prix'} , {data : 'QTE'}];
		//table(col,"#objetsTable");
		$('#client').select2();
		$('#selectArticle').select2();
	})
	$(function() {
		$("#image").on("change", function(){
			var files = !!this.files ? this.files : [];
   if (!files.length || !window.FileReader) return; // Check if File is selected, or no FileReader support
   if (/^image/.test( files[0].type)){ //  Allow only image upload
    var ReaderObj = new FileReader(); // Create instance of the FileReader
    ReaderObj.readAsDataURL(files[0]); // read the file uploaded
    ReaderObj.onloadend = function(){ // set uploaded image data as background of div
    	$("#preview").css("background-image", "url("+this.result+")");
    }
}else{
	alert("Upload an image");
}
});
	});
</script>

@endsection
