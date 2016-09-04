@extends('layouts.master')

@section('head')
	
	@parent

	<title>Edit Thread</title>

@stop

@section('content')

	<div class="clearfix">
		<ol class="breadcrumb pull-left">
		  <li><a href="{{ URL::route('forum-home') }}">Forum</a></li>
		  <li><a href="{{ URL::route('forum-category', $thread->category_id) }}">{{ $thread->category->title }}</a></li>		  
		  <li><a href="{{ URL::route('forum-thread', $thread->id) }}">{{ $thread->title }}</a></li>
		</ol>
	</div>	
	<h1>Edit Thread</h1>
		<form action="{{ URL::route('forum-edit-thread', $thread->id) }}" method= "post">
			<input type="hidden" name="_method" value="PUT">
			<div class="form-group">
				<label for="title">Title: </label>
				<input type="text" class="form-control" name="title" id="title" value= "{{ $thread->title }}"/>
			</div>
			<div class="form-group">
				<label for="body">Body: </label>
				<textarea class="form-control" name="body" id="body">{{ $thread->body }}</textarea>
			</div>
			{{ Form::token() }}
			<div class="form-group">
				<input type="submit" value="Update Thread" class="btn btn-primary">
			</div>
		</form>
@stop