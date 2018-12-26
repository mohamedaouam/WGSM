@extends('default')

@section('stylesheet')
<link rel="stylesheet" href="{{asset('plugin/select2/css/select2.css')}}">
<style>
#preview {
	width: 150px;
	height: 150px;
	background-position: center center;
	background-size: cover;
	background: url('{{asset('img/'.$MODEL->image)}}');
	background-size:100% 100%;
	-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
	display: inline-block;
}
</style>
@endsection

@section('content')

<div class="col-10 mx-auto row mt-2 p-1">
	<form action="{{Route('upModel')}}" method="POST" class="col-11 mx-auto my-1 row" enctype="multipart/form-data">
		<div id="profile" class="col-11 row mx-auto mb-5 pt-3">
			<div class="mx-auto" id="preview"></div>
			<div class="custom-file col-8 mt-5">
				<input type="file" class="custom-file-input"  name="image" id="image">
				<label for="image" class="custom-file-label">Selectioner une Image</label>
			</div>
		</div>
		<input type="hidden" name="id" value="{{$MODEL->id_model}}">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="form-group col-6">
			<label for="nom">Nom :</label> <input type="text"
			name="nom" placeholder="" id="nom" value="{{$MODEL->nom}}" 
			class="form-control">
		</div>
		<div class="form-group col-6">
			<label for="ref">Referance :</label> <input type="text"
			name="ref" placeholder="" id="ref" value="{{$MODEL->ref}}"
			class="form-control">
		</div>
		<div class="form-group col-6">
			<label for="description">Description :</label> <input type="text"
			name="description" placeholder="" id="description" value="{{$MODEL->description}}"
			class="form-control">
		</div>
		<div class="form-group col-6">
			<label for="bonus">Bonus :</label> <input type="number"
			name="bonus" placeholder="" id="bonus" value="{{$MODEL->bonus}}" 
			class="form-control">
		</div>
		<div class="col-10 row mx-auto">
			<div class="input-group col-12 mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text" id="">Objet </span>
				</div>
				<select name="nothing"  class="custom-select" id="objets">
					@foreach(\App\Objet::where('visible',1)->get() as $obj)
					@if($MODEL->getKitsObjetID() != null)
					@if(!$MODEL->iHaveIt($obj->id_objet))
					<option value="{{$obj->id_objet}}" ref="{{$obj->ref}}">{{$obj->nom." ".$obj->description}}</option>
					@endif
					@else
					<option value="{{$obj->id_objet}}" ref="{{$obj->ref}}">{{$obj->nom." ".$obj->description}}</option>
					@endif
					@endforeach
				</select>
				<div class="input-group-append">
					<button class="btn btn-outline-success" onclick="Add()" type="button"><span class="icon icon-plus"></span></button>
				</div>
			</div>
		</div>
		<div class="col-12 row" id="kits">
			@foreach($KITS as $kit)
			<div class="input-group col-12 mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text" onclick="to()" id="">{{$kit->getRef()}}</span>
				</div>
				<input type="text" name="X[]" value="{{$kit->X}}" class="form-control">
				<input type="text" name="Y[]" value="{{$kit->Y}}" class="form-control">
				<input type="text" name="Z[]" value="{{$kit->Z}}" class="form-control">
				<input type="hidden" name="id_obj[]" value="{{$kit->id_objet}}">
				<div class="input-group-append">
					<button class="btn btn-outline-danger" onclick="removeMe()" type="button"><span class="icon icon-times"></span></button>
				</div>
			</div>
			@endforeach
		</div>
        <div class="col-10 row mx-auto">
			<div class="input-group col-12 mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text" id="">Categorie : </span>
				</div>
				<select name="nothing"  class="custom-select" id="categories">
					@foreach($MODEL->getAvailableCategories() as $cat)
					  <option value="{{ $cat->categorie }}">{{$cat->categorie }}</option>
					@endforeach
				</select>
				<div class="input-group-append">
					<button class="btn btn-outline-success" onclick="AddCat()" type="button"><span class="icon icon-plus"></span></button>
				</div>
			</div>
		</div>
		<div class="col-12 row" id="cats">
			@foreach($MODEL->getCategories() as $cat)
			<div class="input-group col-12 mb-2">
				<div class="input-group-prepend">
					<span class="input-group-text" >{{$cat->categorie}}</span>
				</div>
				<input type="text" name="formules[]" value="{{$cat->formule}}" class="form-control">
				<input type="hidden" name="categories[]" value="{{$cat->categorie}}">
				<div class="input-group-append">
					<button class="btn btn-outline-danger" onclick="catRemoveMe($(this))" type="button"><span class="icon icon-times"></span></button>
				</div>
			</div>
			@endforeach
		</div>
		<div class="form-group col-6 text-center mx-auto">
			<button class="btn btn-primary" type="submit"><span class="pr-2 icon icon-check-2"></span> Enregistrer</button>
			<a class="btn btn-danger text-white" onclick="document.location.href='{{Route('delModel',['id'=>$MODEL->id_model])}}';"href="javascript:void(0)"><span class="pr-2 icon icon-trash"></span> Supprimer</a>
		</div>
	</form>
</div>

@endsection
@section('scripts')
<script src="{{asset('plugin/select2/js/select2.js')}}"></script>

<script>
	data = []
	function removeMe(t){
		id = t.attr('id')
		text = null
		for(i = 0 ; i < data.length;i++){
			if(data[i].id == id){
				text = data[i].data
				data.splice(i,1)
				break
			}
		}
		option = "<option value='"+id+"'>"+text+"</option>";
		$('#objets').append(option)
		$('#'+id).remove();

	}
	function catRemoveMe(t){
		id = t.attr('id')
		option = "<option value='"+id+"'>"+id+"</option>";
		$('#categories').append(option)
		$('#'+id).remove();

	}
	function AddCat(){
		id = $('#categories option:selected').val();
		div = "<div class='input-group col-12 mb-2' id='"+id+"'>"+"<div class='input-group-prepend'>"
		+"<span class='input-group-text'>"+id+"</span>"+
		"</div>"+
		"<input type='text' name='formules[]' value='1' class='form-control'>"+
		"<input type='hidden' name='categories[]' value='"+id+"'>"+
		"<div class='input-group-append'>"+
		"<button class='btn btn-outline-danger' id='"+id+"' onclick='catRemoveMe($(this))' type='button'><span class='icon icon-times'></span></button>"+
		"</div>"+
		"</div>";
		$('#cats').prepend(div);
		$('#categories option:selected').remove();

	}
	function Add(){
		id = $('#objets option:selected').val();
		ref = $('#objets option:selected').attr('ref');
		div = "<div class='input-group col-12 mb-2' id='"+id+"'>"+"<div class='input-group-prepend'>"
		+"<span class='input-group-text'>"+ref+"</span>"+
		"</div>"+
		"<input type='text' name='X[]' value='1' class='form-control'>"+
		"<input type='text' name='Y[]' value='0' class='form-control'>"+
		"<input type='text' name='Z[]' value='0' class='form-control'>"+
		"<input type='hidden' name='id_obj[]' value='"+id+"'>"+
		"<div class='input-group-append'>"+
		"<button class='btn btn-outline-danger' id='"+id+"' onclick='removeMe($(this))' type='button'><span class='icon icon-times'></span></button>"+
		"</div>"+
		"</div>";
		$('#kits').prepend(div);
		data.push(  {data : $('#objets option:selected').text() , id:id});
		$('#objets option:selected').remove();

	}
	$(document).ready(function(){
		$('#objets').select2();
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