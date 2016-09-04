@extends('layouts.master')

@section('head')
	@parent
	<title>Change Password</title>
@stop

@section('content')

	<div class="container">
		<h1>Change Password</h1>
		<form role="form", method="post" action="{{ URL::route('postChangepassword') }}">

			<div class="form-group {{ ($errors -> has('old_password')) ? 'has-error' : '' }}">
				<label for="old_password">Old password: </label>
				<input id="old_password" name="old_password" type="password" class="form-control">
				@if($errors->has('old_password'))
					{{ $errors->first('old_password') }}
				@endif
			</div>
			<div class="form-group {{ ($errors -> has('password')) ? 'has-error' : '' }}">
				<label for="password">New Password: </label>
				<input id="password" name="password" type="password" class="form-control">
				@if($errors->has('password'))
					{{ $errors->first('password')}}
				@endif
			</div>
			<div class="form-group {{ ($errors -> has('password_again')) ? 'has-error' : '' }}">
				<label for="password_again">Confirm Password: </label>
				<input id="password_again" name="password_again" type="password" class="form-control">
				@if($errors->has('password_again'))
					{{ $errors->first('password_again')}}
				@endif
			</div>
			{{ Form::token() }}
			<div class="form-grouup">
				<input type="submit" value="Change Password" class="btn btn-danger">
			</div>
		</form>
	</div>
@stop