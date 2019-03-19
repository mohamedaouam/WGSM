@extends('default')

@section('stylesheet')
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
#preview {
	width: 150px;
	height: 150px;
	background-position: center center;
	background-size: cover;
	background: url('{{asset('img/default.png')}}');
	background-size:100% 100%;
	-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
	display: inline-block;
}
</style>
@endsection

@section('content')
<div class="col-12 mx-auto pt-3">
	<ul class="nav nav-tabs text-center mx-auto col-10" id="tabb">
		<li class="nav-item"><a class="nav-link active" data-toggle="tab"
			href="#ListObjets"><span class="icon icon-users"></span> List
		Objets</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab"
			href="#AjouterObjet"><span class="icon icon-plus"></span>
		Ajouter un objet</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab"
			href="#EnStocker"><span class="icon icon-plus"></span>
		En stocker</a></li>
		

	</ul>
	<div
	class="tab-content col-10 mx-auto border py-2 border-top-0 rounded-bottom">
	<div class="tab-pane fade show active row" id="ListObjets"
	role="tabpanel" aria-labelledby="listClients-tab">

	<div class="col-11 mx-auto">
		<table class="table table-striped table-hover" id="objetsTable">
			<thead>
				<tr>
					<th>ID</th>
					<th>Referance</th>
					<th>Nom</th>
					<th>Prix</th>
					<th>QTE</th>
					
				</tr>
			</thead>
			<tbody>
				@foreach($OBJETS as $objet)
				<tr>
					<td>{{$objet['id_objet']}}</td>
					<td>{{$objet['ref']}}</td>
					<td><a href="javascript:void(0)" onclick="document.location.href='{{Route('objet',['id'=>$objet->id_objet , 'name' => $objet->nom])}}';">{{$objet['nom']}}</a></td>
					<td>{{$objet['prix']}}</td>
					<td>{{$objet['enStock']}}</td>
				</tr>
				@endforeach
				
			</tbody>
		</table>
	</div>
</div>
<div class="tab-pane fade" id="AjouterObjet" role="tabpanel"
aria-labelledby="ajouterObjet-tab">
<form class="row" action="{{Route('addStocks')}}" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<div id="profile" class="col-11 row mx-auto mb-5 pt-3">
		<div class="mx-auto" id="preview"></div>
		<div class="custom-file col-8 mt-5">
			<input type="file" class="custom-file-input" name="image" id="image">
			<label for="image" class="custom-file-label">Selectioner une Image</label>
		</div>
	</div>
	<div class="form-group col-6">
		<label for="nom">Nom objet :</label> <input type="text"
		name="nom" placeholder="visse 5mm" id="nom"
		class="form-control">
	</div>
	<div class="form-group col-6">
		<label for="ref">Referance :</label> <input type="text"
		name="ref" placeholder="XXXXXXXX" id="ref"
		class="form-control">
	</div>
	<div class="form-group col-6">
		<label for="description">Description :</label> <input type="text"
		name="description" placeholder="" id="description"
		class="form-control">
	</div>
	<div class="form-group col-6">
		<label for="categorie">Categorie :</label> <input type="text"
		name="categorie" placeholder="categorie" id="categorie"
		class="form-control">
	</div>
	<div class="form-group col-6">
		<label for="prix">Prix (DZD):</label> <input step="0.01" type="number" min="5"
		name="prix" placeholder="10,00" id="prix"
		class="form-control">
	</div>
	<div class="form-group col-6 mx-auto">
		<label for="enStock">Quantité :</label> 
		<input type="number" class="form-control" name="enStock" value="0" min="0" id="enStock">
	</div>
	<div class="form-group col-7 text-center mx-auto">
		<button class="btn btn-primary" type="submit"><span class="pr-2 icon icon-check-2"></span> Valider</button>
	</div>
</form>
</div>
<div class="tab-pane fade row" id="EnStocker" role="tabpanel"
aria-labelledby="ajouterObjet-tab">

<div class="col-11 mx-auto pb-3 mb-2 border-bottom" id="tEN">
	<table class="table table-hover table-striped col-11 mx-auto">
		<thead>
			<tr>
				<th>
					ID
				</th>
				<th>
					REF
				</th>
				<th>
					NOM
				</th>
				<th>
					QTE
				</th>
				<th>

				</th>
			</tr>
		</thead>
		<tbody id="enStock" class="text-center">

		</tbody>
	</table>
</div>
<div class="row col-11 mx-auto">
	<select name="" id="selectObjet" class="form-control col-8 mx-auto">
		@foreach($OBJETS as $objet)
		<option value="{{$objet->ref}}">{{$objet->ref .' '. $objet->nom .' '.$objet->description}}</option>
		@endforeach
	</select>
	<input type="number" min="1" id="qteObjet" class="form-control col-2 mx-auto">
	<button class="btn btn-success mx-auto col-2" onclick="add()"><span class="icon icon-plus"></span> Ajouter</button>
</div>
<div class="row col-11 mx-auto mt-5 pt-3 border-top">
	
	<form action="" method="POST" id="enstocker">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="hidden" name="_method" value="PUT">
		<button class="mx-auto btn btn-primary" type="submit"><span class="icon icon-check"></span> Valider</button>
	</form>

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

	function add(){
		var ref = $('#selectObjet').val();
		objets = [
		@foreach($OBJETS as $objet)
		["{{$objet->id_objet}}","{{$objet->ref}}","{{$objet->nom}}"
		],
		@endforeach
		];
		id= "";
		nom ="";
		for (var i = 0; i < objets.length; i++) {
			if(ref == objets[i][1] ){
				nom = objets[i][2];
				id = objets[i][0];
				break;
			}
		}
		qte = $('#qteObjet').val();
		row = "<tr id='"+id+ref+"'><td>"+id+"</td><td>"+ref+"</td><td>"+nom+"</td><td>"+qte+"</td><td><span class='icon icon-trash text-danger' onclick='del(this)'></span></td></tr>";
		input1 = "<input id='"+id+ref+"' type='hidden' name='objet[]' value='"+ref+"' >";
		input2 = "<input id='"+id+ref+"' type='hidden' name='qte[]' value='"+qte+"' >";
		$('tbody#enStock').append(row);
		$('form#enstocker').append(input1);
		$('form#enstocker').append(input2);
	}
	function del(obj){
		id = obj.parentNode.parentNode.getAttribute('id');
		obj.parentNode.parentNode.remove();
		$('#'+id).remove();
		$('#'+id).remove();
	}
	$(document).ready(function(){
		col = [ { data : 'ID' }, {data : 'Referance'} , {data: 'nom'} , {data: 'Prix'} , {data : 'QTE'}];
		table(col,"#objetsTable");
		$('#selectObjet').select2();
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
