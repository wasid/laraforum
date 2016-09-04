@extends('layouts.master')

@section('head')
	@parent
	<title>Login</title>
@stop

@section('content')
	
	<div class="container">
		<h1>Login</h1>
		<form role="form", method="post" action="{{ URL::route('postLogin') }}">
		{{ Form::token() }}
			<div class="form-group {{ ($errors -> has('email')) ? 'has-error' : '' }}">
				<label for="email">Email: </label>
				<input id="email" name="email" value="{{ Input::old('email') }}" type="text" class="form-control">
				@if($errors->has('email'))
					{{ $errors->first('email') }}
				@endif
			</div>
			<div class="form-group {{ ($errors -> has('password')) ? 'has-error' : '' }}">
				<label for="password">Password: </label>
				<input id="password" name="password" type="password" class="form-control">
				@if($errors->has('password'))
					{{ $errors->first('password')}}
				@endif
			</div>
			<div class="checkbox">
				<label for="remember">
					<input type="checkbox" name="remember" id="remember">
					Remember Me
			</div>
			
			<div class="form-grouup">
				<input type="submit" value="Login" class="btn btn-default">
			</div>
		</form>
	</div>
@stop