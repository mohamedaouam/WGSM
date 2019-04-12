@extends('notification')
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $TITLE}} | WiGSV</title>
	<link rel="icon" href="{{asset('favicon.png')}}">
	<link rel="stylesheet" href=" {{asset('plugin/bootstrap/css/bootstrap.min.css')}} ">
	<link rel="stylesheet" href="{{asset('icons/fontastic/css/fontastic.css')}}">
	<link rel="stylesheet" href="{{asset('css/nav.css')}}">
	@yield('stylesheet')
</head>
<body class="p-0 m-0" onload="startTime()">
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed">
		<a class="navbar-brand" href="javascript:void(0)" onclick="document.location.href='{{Route('home')}}';">WiGSV <sup><sup>MN</sup></sup></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse"
		data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
		aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse">
		<ul class="navbar-nav">
			<li class="nav-item " id="home"><a class="nav-link"
				href="javascript:void(0)" onclick="document.location.href='{{Route('home')}}';"><span class="icon icon-home"></span>
			Home </a></li>
			
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span
					class="icon icon-file-text"></span>Factures
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown1">
					<a class="dropdown-item" href="javascript:void(0)" onclick="document.location.href='{{Route('factures')}}';">Factures objets</a>
					<a class="dropdown-item"href="javascript:void(0)" onclick="document.location.href='{{Route('facturesM')}}';">Factures Models</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Something else here</a>
				</div>
			</li>
			<li class="nav-item" id="stocks"><a class="nav-link"
				href="javascript:void(0)" onclick="document.location.href='{{Route('stocks')}}';"><span
				class="icon icon-database"></span>Stocks</a></li>
				<li class="nav-item" id="models"><a class="nav-link"
					href="javascript:void(0)" onclick="document.location.href='{{Route('models')}}';"><span
					class="icon icon-tools"></span>Models </a></li>
					<li class="nav-item" id="clients"><a class="nav-link"
						href="javascript:void(0)" onclick="document.location.href='{{Route('clients')}}';"><span
						class="icon icon-users"></span>Clients </a></li>
						<li class="nav-item" id="clients"><a class="nav-link"
							href="javascript:void(0)" onclick="document.location.href='{{Route('clients')}}';"><span
							class="icon icon-users"></span>Autre charges </a></li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Autre
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="#">Billant de l'anne</a>
									<a class="dropdown-item" href="#">Another action</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">Something else here</a>
								</div>
							</li>
						</ul>
					</div>
					<div class="float-right collapse navbar-collapse">

					</div>
				</nav>

				@include('notification')

				<div class="row col-12">
					<div class="col-2 fixed h-100"  >
						<ul class="list-group list-group-flush text-center">
							<li class="list-group-item l-nav px-0"><a class="nav-link disabled row" href="javascript:void(0)"><span
								class="icon icon-user col-1"></span>{{Auth::user()->name}}</a></li>
								<li class="list-group-item l-nav px-0"><a class="nav-link disabled row" href="javascript:void(0)"><span
									class="icon icon-building col-1 float-left"></span>{{$DEVICE}}</a></li>
									<li class="list-group-item l-nav px-0"><a class="nav-link disabled row" href="javascript:void(0)"><span
										class="icon icon-calendar col-1 float-left"></span>{{$DATE}}</a></li>
										<li class="list-group-item l-nav px-0"><a class="nav-link disabled row" id="DT"
											href="javascript:void(0)"><span class="icon icon-clock-o col-1 float-left"></span>00:00:00</a></li>
											<li class="list-group-item l-nav px-0"><a class="nav-link row "
												href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span
												class="icon icon-power col-1 float-left"></span> Logout</a></li>
											</ul>
											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"><input type="hidden" name="_token" value="{{ csrf_token() }}"></form>
										</div>
										<div class="col-10">
											@yield('content')
										</div>
									</div>
									<footer class="page-footer font-large ">

										<!-- Copyright -->
										<div class="footer-copyright text-center py-3">© 2018 Copyright:
											<a class="footer-link" style="text-decoration: none; " href="http://wigsv.wicom.dz">Wicom.dz</a>
										</div>
										<!-- Copyright -->

									</footer>
									<!-- Footer -->
									<script src="{{asset('plugin/jquery/js/jquery.js')}}"></script>
									<script src="{{asset('plugin/popper/js/popper.js')}}"></script>
									<script src="{{asset('plugin/bootstrap/js/bootstrap.min.js')}}"></script>
									<script src="{{asset('js/pager.js')}}"></script>
									<script src="{{asset('js/clock.js')}}"></script>
									@yield('scripts')
								</body>
								</html>