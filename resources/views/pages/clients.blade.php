@extends('default')

@section('stylesheet')
<link rel="stylesheet" href="{{asset('plugin/datatable/DataTables/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('plugin/datatable/Buttons/css/buttons.bootstrap4.css')}}">
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
</style>
@endsection

@section('content')
<div class="col-12 mx-auto pt-3">
	<ul class="nav nav-tabs text-center mx-auto col-10" id="tabb">
		<li class="nav-item"><a class="nav-link active" data-toggle="tab"
			href="#ListClients"><span class="icon icon-users"></span> List
		clients</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab"
			href="#AjouterClient"><span class="icon icon-user-plus"></span>
		Ajouter un client</a></li>

	</ul>
	<div
	class="tab-content col-10 mx-auto border py-2 border-top-0 rounded-bottom">
	<div class="tab-pane fade show active row" id="ListClients"
	role="tabpanel" aria-labelledby="listClients-tab">

	<div class="col-11 mx-auto">
		<table class="table table-striped table-hover" id="clientsTable">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nom</th>
					<th>Tél</th>
				</tr>
			</thead>
			<tbody>
				@foreach($CLIENTS as $client)
				<tr>
					<td>{{$client['id_client']}}</td>
					<td><a href="javascript:void(0)" onclick="document.location.href='{{Route('client',['id'=>$client->id_client , 'name' => $client->name])}}';">{{$client['name']}}</a></td>
					<td>{{$client['tel']}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<div class="tab-pane fade" id="AjouterClient" role="tabpanel"
aria-labelledby="ajouterClient-tab">
<form class="row" method="POST">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<div class="form-group col-6">
		<label for="nom">Nom client :</label> <input type="text"
		name="name" placeholder="AOUAM Mohamed" id="nom"
		class="form-control">
	</div>
	<div class="form-group col-6">
		<label for="typeClient">Télephone :</label> <input type="text"
		name="phone" placeholder="0XXX XX XX XX" id="typeClient"
		class="form-control">
	</div>
	<div class="form-group col-6">
		<label for="adress">Adress :</label> <input type="text"
		name="addr" placeholder="EPLF TIZI OUZOU" id="adress"
		class="form-control">
	</div>
	<div class="form-group col-6">
		<label for="adress">Email :</label> <input type="email"
		name="email" placeholder="allworks@exemple.dz" id="email"
		class="form-control">
	</div>
	<div class="form-group col-6">
		<label for="typeC">Type client :</label> <select name="typeC"
		onchange="check()" id="typeC" class="form-control">
		<option value="0" selected>Particulier</option>
		<option value="1">Entreprise</option>
	</select>
</div>
<div class="form-group col-6">
	<label for="rc">RC :</label> <input type="text" name="RC"
	placeholder="XXXXXXXX" id="rc" class="form-control" disabled>
</div>
<div class="form-group col-6 text-center mx-auto">
	<button class="btn btn-primary" type="submit"><span class="pr-2 icon icon-check-2"></span> Valider</button>
</div>
</form>
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
<script src="{{asset('js/clients.js')}}"></script>
<script>
	function check() {
		t = $('#typeC');
		if (t.val() == 0)
			$('#rc').attr('disabled','')
		else
			$('#rc').removeAttr('disabled','')
	}
</script>
@endsection
