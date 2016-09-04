<!doctype html>
<html lang="en">
<head>
	@section('head')
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<style>
		body{

			padding-top: 60px;
			padding-bottom: 50px;
		}
	</style>
	@show
</head>
<body>
	<div class="navbar navbar-custom navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
	 			</button>
	 			<a href="{{ URL::route('home') }}" class="navbar-brand" >Brand</a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
					<li><a href="{{ URL::route('forum-home') }}">Forums</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if(!Auth::check())
						<li><a href="{{ URL::route('getCreate') }}">Register</a></li>
						<li><a href="{{ URL::route('getLogin') }}">Login</a></li>
					@else
						<li class="dropdown">
         				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hello, {{{ isset(Auth::user()->username) ? Auth::user()->username : Auth::user()->email }}}<span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href="#">Profile</a></li>
				            <li><a href="{{ URL::route('getChangepassword') }}">Change password</a></li>
				            <li><a href="{{ URL::route('getLogout') }}">LogOut</a></li>
				          </ul>
				        </li>
				      </ul>
					@endif
				</ul>
			</div>
		</div>
	</div>
	<div class="container">

       	<div class="form-group pull-right" id="searchbar">

       		{{ Form::open(['route' => 'forum-search']) }}

			{{ Form::token() }}

       		{{ Form::text('keyword', null, ['placeholder' => 'Search...'], array('id' => 'keyword')) }}

			{{ Form::submit('Search', ['class' => 'btn btn-success btn-xs']) }}

    		{{ Form::close() }}
    	</div>
    	
    </div>

	@if(Session::has('success'))

	<div id = "success" class="alert alert-success"><center>{{ Session::get('success') }}</center></div>

	@elseif(Session::has('info'))

	<div id = "info" class="alert alert-info"><center>{{ Session::get('info') }}</center></div>
	
	@elseif(Session::has('fail'))

	<div id = "danger" class="alert alert-danger"><center>{{ Session::get('fail') }}</center></div>
	
	@endif



	<div class="container">@yield('content')</div>
	@section('javascript')
		<script src="http://code.jquery.com/jquery-1.12.0.min.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	@show

</body>
	<div class="navbar navbar-default navbar-fixed-bottom">
		<div id="footer">
			<div class="container">
			<p class="navbar-text pull-right">Developed by: <a href="#">M. M. Wasid Hossain</a></p>
			</div>
		</div>
	</div>

</html>