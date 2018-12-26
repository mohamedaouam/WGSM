@extends('default')

@section('stylesheet')
<style>
#preview {
	width: 150px;
	height: 150px;
	background-position: center center;
	background-size: cover;
	background: url('{{asset('img/'.$OBJET->image)}}');
	background-size:100% 100%;
	-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
	display: inline-block;
}
</style>
@endsection
@section('content')

<div class="col-10 mx-auto row mt-2 p-1">
	<form action="{{Route('upObjet')}}" method="POST" class="col-11 mx-auto my-1 row" enctype="multipart/form-data">
		<input type="hidden" name="id" value="{{$OBJET->id_objet}}">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div id="profile" class="col-11 row mx-auto mb-5 pt-3">
			<div class="mx-auto" id="preview"></div>
			<div class="custom-file col-8 mt-5">
				<input type="file" class="custom-file-input"  name="image" id="image">
				<label for="image" class="custom-file-label">Selectioner une Image</label>
			</div>
		</div>
		<div class="form-group col-6">
			<label for="nom">Nom :</label> <input type="text"
			name="nom" placeholder="" id="nom" value="{{$OBJET->nom}}" 
			class="form-control">
		</div>
		<div class="form-group col-6">
			<label for="ref">Refirance :</label> <input type="text"
			name="ref" placeholder="XXXXXXXX" id="ref" value="{{$OBJET->ref}}"
			class="form-control">
		</div>
		<div class="form-group col-12">
			<label for="description">Description :</label> <input type="text"
			name="description" placeholder="" id="description" value="{{$OBJET->description}}"
			class="form-control">
		</div>
		<div class="form-group col-6">
			<label for="prix">Prix :</label> <input type="number" step="0.01"
			name="prix" placeholder="" id="prix" value="{{$OBJET->prix}}" 
			class="form-control">
		</div>
		<div class="form-group col-6 mx-auto">
			<label for="cat">Categorie :</label> <input type="text"
			name="categorie" placeholder="" id="cat" value="{{$OBJET->categorie}}" 
			class="form-control">
		</div>
		<div class="form-group col-6 text-center mx-auto">
			<button class="btn btn-primary" type="submit"><span class="pr-2 icon icon-check-2"></span> Enregistrer</button>
			<a class="btn btn-danger text-white" href="javascript:void(0)" onclick="document.location.href='{{Route('deleteO',['id' =>$OBJET->id_objet])}}';"><span class="pr-2 icon icon-trash"></span> Supprimer</a>
		</div>
	</form>
</div>

@endsection
@section('scripts')
<script>
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