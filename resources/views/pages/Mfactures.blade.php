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
<div class="col-12 mx-auto pt-3">
	<ul class="nav nav-tabs text-center mx-auto col-10" id="tabb">
		<li class="nav-item"><a class="nav-link active" data-toggle="tab"
			href="#ListFactures"><span class="icon icon-files-o"></span> List
		Factures</a></li>
	</ul>
	<div
	class="tab-content col-10 mx-auto border py-2 border-top-0 rounded-bottom">
	<div class="tab-pane fade show active row" id="ListFactures"
	role="tabpanel" aria-labelledby="listFactures-tab">

	<div class="col-11 mx-auto">
		<div class="row mb-2"> <button type="button" onclick="document.location.href='{{route('newFM')}}';" class="mx-auto col-4 text-center btn btn-primary"><span class="icon icon-file-text-o"></span> Nouvelle Facture</button></div>
		<table class="table table-striped table-hover" id="objetsTable">
			<thead>
				<tr>
					<th>Etat</th>
					<th>Referance</th>
					<th>Client</th>
					<th>Montant</th>
					
					
				</tr>
			</thead>
			<tbody>
				@foreach(\App\FactureModels::orderBy('id_factureModel','DESC')->get() as $facture)
				<tr>
					<td><span class="icon @if($facture->valider && $facture->payer &&  $facture->livre) icon-check @else icon-clock-o @endif "></span></td>
					
					<td><a href="javascript:void(0)" onclick="" >{{$facture->ref}}</a></td>
					<td><a href="javascript:void(0)" onclick="document.location.href='{{Route('client',['id'=>$facture->id_client,'name'=>$facture->getClient()->name])}}';" > {{$facture->getClient()->name}}</a></td>
					<td>{{$facture->montant}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
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
