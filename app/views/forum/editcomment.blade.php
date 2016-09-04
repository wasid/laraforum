@extends('layouts.master')

@section('head')
	
	@parent

	<title>edit comment</title>

@stop

@section('content')

	<div class="clearfix">
		<ol class="breadcrumb pull-left">
		  <li><a href="{{ URL::route('forum-home') }}">Forum</a></li>
		  <li><a href="{{ URL::route('forum-category', $comment->thread->category->id) }}">{{ $comment->thread->category->title }}</a></li>		  
		  <li><a href="{{ URL::route('forum-thread', $comment->thread->id) }}">{{ $comment->thread->title }}</a></li>
		</ol>
	</div>
	
	<h1>Edit Comment</h1>

	<form action="{{ URL::route('forum-edit-comment', $comment->id) }}" method= "post">
		<input type="hidden" name="_method" value="PUT">
		<div class="form-group">
			<label for="body">Body: </label>
			<textarea class="form-control" name="body" id="body">{{ $comment->body }}</textarea>
		</div>
		{{ Form::token() }}
		<div class="form-group">
			<input type="submit" value="Update Comment" class="btn btn-primary">
		</div>
	</form>

@stop