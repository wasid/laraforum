@extends('layouts.master')

@section('head')
	@parent
	<title>Forum </title>
@stop
@section('content')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::route('forum-home') }}">User Profile</a></li>
	 </ol>
		
	    	<img src="https://www.leanstartupmachine.com/images/default_profile_photo.png">	
			<li><a href="#">{{ Auth::user()->username }}</a></li>
			<li><a href="#">{{ Auth::user()->email }}</a></li>

@stop
