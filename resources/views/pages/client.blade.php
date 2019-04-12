@extends('default')

@section('stylesheet')
@endsection
@section('content')

<div class="col-11 mx-auto row mt-2 p-1">
	<form action="{{Route('upClient')}}" method="POST" class="col-11 mx-auto my-1 row">
		<input type="hidden" name="id" value="{{$CLIENT->id_client}}">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="form-group col-6">
			<label for="nom">Nom client :</label> <input type="text"
			name="name" placeholder="" id="nom" value="{{$CLIENT->name}}" 
			class="form-control">
		</div>
		<div class="form-group col-6">
			<label for="typeClient">Télephone :</label> <input type="text"
			name="phone" placeholder="0XXX XX XX XX" id="typeClient" value="{{$CLIENT->tel}}"
			class="form-control">
		</div>
		<div class="form-group col-6">
			<label for="adress">Adress :</label> <input type="text"
			name="addr" placeholder="EPLF TIZI OUZOU" id="adress" value="{{$CLIENT->adress}}"
			class="form-control">
		</div>
		<div class="form-group col-6">
			<label for="adress">Email :</label> <input type="email"
			name="email" placeholder="allworks@exemple.dz" id="email" value="{{$CLIENT->email}}" 
			class="form-control">
		</div>
		<div class="form-group col-6">
			<label for="typeC">Type client :</label> <select name="typeC"
			onchange="check()" id="typeC" class="form-control">
			<option value="0" {{$CLIENT->typeCompte ? "" : "selected"}}>Particulier</option>
			<option value="1" {{$CLIENT->typeCompte ? "selected" : ""}}>Entreprise</option>
		</select>
	</div>
	<div class="form-group col-6">
		<label for="rc">RC :</label> <input type="text" name="RC"
		placeholder="XXXXXXXX" id="rc" class="form-control"  value="{{$CLIENT->rc}}" {{$CLIENT->typeCompte ? "" : "disabled"}}>
	</div>
	<div class="form-group col-6 text-center mx-auto">
		<button class="btn btn-primary" type="submit"><span class="pr-2 icon icon-check-2"></span> Enregistrer</button>
		<a class="btn btn-danger text-white" href="javascript:void(0)" onclick="document.location.href='{{Route('deleteC',['id' =>$CLIENT->id_client])}}';"><span class="pr-2 icon icon-trash"></span> Supprimer</a>
	</div>
</form>
</div>

@endsection
@section('scripts')
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