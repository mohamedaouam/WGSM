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
<div class="col-11 mx-auto pt-3">
	<ul class="nav nav-tabs text-center mx-auto col-8" id="tabb">
		<li class="nav-item"><a class="nav-link active" data-toggle="tab"
			href="#ListModels"><span class="icon icon-users"></span> List
		models</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab"
			href="#AjouterModel"><span class="icon icon-user-plus"></span>
		Ajouter un Model</a></li>

	</ul>
	<div
	class="tab-content col-8 mx-auto border py-2 border-top-0 rounded-bottom">
	<div class="tab-pane fade show active row" id="ListModels" role="tabpanel" aria-labelledby="listModels-tab">
		<div class="col-11 mx-auto">
			<table class="table table-striped table-hover" id="modelsTable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Ref</th>
						<th>Nom</th>
					</tr>
				</thead>
				<tbody>
					@foreach(\App\Composer::where('visible',1)->get() as $model){
					<tr>
						<td>
							{{$model->id_model}}
						</td>
						<td>
							{{$model->ref}}
						</td>
						<td>
							<a href="javascript:void(0)" onclick="document.location.href='{{Route('modelObj',['id'=>$model->id_model])}}';">
								{{$model->nom}}
							</a>
						</td>
					</tr>
					@endforeach
				}
			</tbody>
		</table>
	</div>
</div>
<div class="tab-pane fade" id="AjouterModel" role="tabpanel"
aria-labelledby="ajouterModel-tab">
<form class="row" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<div id="profile" class="col-11 row mx-auto mb-5 pt-3">
		<div class="mx-auto" id="preview"></div>
		<div class="custom-file col-8 mt-5">
			<input type="file" class="custom-file-input" name="image" id="image">
			<label for="image" class="custom-file-label">Selectioner une Image</label>
		</div>
	</div>
	<div class="form-group col-6">
		<label for="nom">Nom :</label> <input type="text"
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
		<label for="prix">Bonus (%) :</label> <input step="0.01" type="number" min="5"
		name="prix" placeholder="10,00" id="prix"
		class="form-control">
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
<script src="{{asset('js/dateTable.js')}}"></script>

<script>
	$(document).ready(function(){
		col = [ { data : 'ID' }, {data : 'Referance'} , {data: 'Nom'} ];
		table(col,"#modelsTable");
	})
</script>
@endsection
