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
<div class="row mt-5">

	<div class="jumbotron mx-auto">
		<h1 class="display-4">Bienvenue !</h1>
		<p class="lead">This is a simple hero unit, a simple
			jumbotron-style component for calling extra attention to featured
		content or information.</p>
		<hr class="my-4">
		<p>It uses utility classes for typography and spacing to space
		content out within the larger container.</p>
		<p class="lead">
			<a class="btn btn-primary btn-lg" href="javascript:void(0)" onclick="document.location.href='{{Route('factures')}}';" role="button">Factures</a> <a class="btn btn-primary btn-lg" href="javascript:void(0)" onclick="document.location.href='{{Route('stocks')}}';" role="button">Stocks</a> 
			<a class="btn btn-primary btn-lg" href="javascript:void(0)" onclick="document.location.href='{{Route('models')}}';" role="button">Models
			</a> <a class="btn btn-primary btn-lg" href="javascript:void(0)" onclick="document.location.href='{{Route('clients')}}';" role="button">Clients
			</a>
		</p>
	</div>
</div>


@endsection

@section('scripts')

@endsection
