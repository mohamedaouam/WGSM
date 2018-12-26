<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Authuntification | WiGSV</title>
	<link rel="icon" href="{{asset('favicon.png')}}">
	<link rel="stylesheet" href=" {{asset('plugin/bootstrap/css/bootstrap.min.css')}} ">
	<link rel="stylesheet" href="{{asset('css/login.css')}}">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent">
			<!-- Tabs Titles -->

			<!-- Icon -->
			<div class="fadeIn first">
				<img src="{{asset('img/log0.png')}}" id="icon" alt="ETS Icon" />
				<h1>WiGSV <sup><sup>MN</sup></sup></h1>
			</div>

			<!-- Login Form -->
			<form method="POST" action="{{ route('login') }}">
				@csrf
				<input type="email" required autofocus id="login" class="fadeIn second " name="email" placeholder="email"><br>
				@if ($errors->has('email'))
				<div class="d-block">
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
				</div>
				@endif
				<input type="password" id="password" required class="fadeIn third " name="password" placeholder="password">
				@if ($errors->has('password'))
				<div class="d-block">
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
				</div>
				@endif
				<input type="submit" class="fadeIn fourth" value="Se Connecter">
			</form>

		</div>
	</div>
	<script src="{{asset('plugin/jquery/js/jquery.js')}}"></script>
	<script src="{{asset('plugin/popper/js/popper.js')}}"></script>
	<script src="{{asset('plugin/bootstrap/js/bootstrap.min.js')}}"></script>
	<script>
		$(document).ready(function(){
			$('.invalid-feedback').show();
		})
	</script>

</body>
</html>