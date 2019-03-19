@extends('default')

@section('stylesheet')
<link rel="stylesheet" href="{{asset('plugin/datatable/DataTables/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('plugin/datatable/Buttons/css/buttons.bootstrap4.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.6/dist/css/bootstrap-select.min.css">
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
.Fheader .icon{
	top: 2px;
	position: relative;
	padding-right: 5px;
}
</style>
@endsection

@section('content')

<div class="col-12 row">
	<div class="col-11 mx-auto row pt-2">
		<h3 class="col-12 text-center border-bottom pb-2 text-primary">Facture N {{\App\FactureModels::GEN()}}</h3>
		<div class="col-12  text-center border-bottom py-2 mx-auto row">
			<div class="input-group col-11 mx-auto row Fheader">
				<div class="input-group-prepend ">
					<label class="input-group-text" for="client"><span class="icon icon-user"></span> Client</label>
				</div>
				<select class="col-7 px-0 selectpicker border-top border-bottom border-left" data-live-search="true" id="client">
					@foreach(\App\Client::orderBy("name")->get() as $client)
					<option value="{{$client->id_client}}">{{$client->name}} ({{$client->tel}})</option>
					@endforeach
				</select>
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" onclick="document.location.href='{{route('clients')}}';" type="button"> <span class="icon icon-user-add"> </span>Ajouter un nouveau client</button>
				</div>
			</div>
		</div>
		<div class="col-12 text-center pt-2 row mx-auto px-0">
			<form action="{{route('newFM')}}" class="col-12 row" method="POST">
				@csrf()
				<div class="input-group col-11 mx-auto row Fheader">
					<div class="input-group-prepend ">
						<label class="input-group-text" for="model"><span class="icon icon-tools"></span> Model</label>
					</div>
					<select id="model" class="col-7 px-0 selectpicker border-top border-bottom border-left" data-live-search="true" id="model">
						@foreach(\App\Composer::orderBy("nom")->get() as $model)
						<option value="{{$model->id_model}}" data-tokens="{{$model->description}}">{{$model->nom}} ({{$model->ref}})</option>
						@endforeach
					</select>
					<div class="input-group-append">
						<button class="btn btn-outline-secondary" id="ajouter" type="button"> <span class="icon icon-plus"> </span>Ajouter</button>
					</div>
				</div>
			</form>
			<div class="objet col-12 d-flex justify-content-around flex-wrap pt-2" id="cadres">
				
			</div>
			<div class="col-12 mt-2 pt-2 border-top row mx-auto">
				<div class="col-6 text-center row ">
					<h3 class="col-6">PRIX : </h3><h3 class="col-6 text-danger">100 DA</h3>
				</div>
				<div class="col-6 text-center row ">
					<div class="form-group col-12 row">
						<label for="inputEmail3" class="col-sm-3 col-form-label">Reduction</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="inputEmail3" value="0">
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 mt-2 pt-2 border-top mx-auto row">
				<button class="btn btn-primary">save</button>
			</div>
			<div class="modals" id="modals">
				
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')


<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.6/dist/js/bootstrap-select.min.js"></script>

<script>
	ELEM = 0;
	function createCadre(data){
		ELEM++
		id = "cadre-"+(ELEM);
		div = "<div class=\"card mt-1 ml-1\" style=\"width: 15rem;\" id = '"+id+"'><img width=238 height=191 src=\"{{asset('img/')}}/"+data['MODEL'].image+"\" class=\"card-img-top\" alt=\"...\"><div class=\"card-body\"><h5 class=\"card-title\">"+ $('#model option:selected').text()+"</h5> <ul class=\"list-group list-group-flush\">    <li class=\"list-group-item VARS\">DIM : "+data['MODEL'].X+"</li>    <li class=\"list-group-item NBR\">Nombre : 1</li>    <li class=\"list-group-item PRIX\">Prix : 1000da</li>  </ul><a href='#' class=\"btn btn-primary my-1\" data-toggle=\"modal\" data-target=\".d-modal-"+(ELEM)+"\">Modifier</a><br><a href='#' class=\"btn btn-primary\" >Dupliquer</a><br><a href='#' class=\"btn btn-danger mt-1\" >Suprimer</a></div></div>"
		$('#cadres').append(div)

	}
	
	function genc(data,c){
		tmp=''
		tmp += "<div class=\"form-group row\">    <label for=\""+c+"\" class=\"col-sm-2 col-form-label\">"+c+"</label>   <div class=\"col-sm-10\">      <select  class=\"form-control\" id=\""+c+"\" >"
		data.forEach(function(o){
			tmp += "<option value='"+o.id_objet+"'>"+o.nom+"</option>" 
		})

		tmp += " </select>    </div>		</div>"
		
		$('#MB-'+ELEM).append(tmp)
	}
	function genCats(Cats){
		
		Cats.forEach(function(c){
			
			$.get(
				"{{route('getobjetbycat')}}" ,
				{cat:c},
				function(res){

					genc(res,c)
				}
				)
		})

	}
	function createModel(data){
		div = "<div class=\"modal fade d-modal-"+ELEM+"\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myExtraLargeModalLabel\" aria-hidden=\"true\"><div class=\"modal-dialog modal-xl\">						<div class=\"modal-content\">							<div class=\"modal-header\">								<h5 class=\"modal-title\" id=\"exampleModalLabel\">"+$('#model option:selected').text()+"</h5>								<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">									<span aria-hidden=\"true\">&times;</span>								</button>							</div>							<div class=\"modal-body\" id='MB-"+ELEM+"'>	<div class=\"form-group row\">    <label for=\"nbr\" class=\"col-sm-2 col-form-label\">Nombre</label>   <div class=\"col-sm-10\">      <input type=\"number\" value='1' min='1' class=\"form-control\" id=\"nbr\" >    </div>		</div> <div class=\"form-group row\">    <label for=\"vars\" class=\"col-sm-2 col-form-label\">Variables</label>   <div class=\"col-sm-10\">      <input type=\"text\" value='X=1 Y=1 Z=1' min='1' class=\"form-control\" id=\"vars\" >  <small id=\"help\" class=\"form-text text-muted\">  "+data['MODEL'].formule+"</small>  </div>		</div>													</div>							<div class=\"modal-footer\">								<button type=\"button\" onclick=\"update('d-modal-"+ELEM+"',"+ELEM+")\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>								<button type=\"button\" class=\"btn btn-primary\">Send message</button>							</div>						</div>					</div>				</div>"
		$('#modals').append(div)
		genCats(data['CATEGORIES'])
	}
	function add(){
		id = $('#model option:selected').val();
		var jqxhr = $.get(
			"{{route('getmodeldata')}}",
			{id:id},
			function (data){
				
				createCadre(data);
				createModel(data);
			}
			)
		
	}
	function update(modal,id){
		
		$('#cadre-'+id + ' .VARS').text('VARS '+$('.'+modal+' input#vars').val())
		$('#cadre-'+id + ' .NBR').text('Nombre '+$('.'+modal+' input#nbr').val())

	}
	$(document).ready(function(){
		$('#ajouter').click(function(){
			
			console.log(add());

		})
	})
</script>
@endsection
