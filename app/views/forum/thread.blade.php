@extends('layouts.master')

@section('head')
	
	@parent

	<title>Forum | {{ $thread->title }}</title>

@stop

@section('content')
	<div class="clearfix">
		<ol class="breadcrumb pull-left">
		  <li><a href="{{ URL::route('forum-home') }}">Forum</a></li>
		  <li><a href="{{ URL::route('forum-category', $thread->category_id) }}">{{ $thread->category->title }}</a></li>		  
		  <li class="active">{{ $thread->title }}</li>
		</ol>
		@if(Auth::check() && Auth::user()->isAdmin())
			<a id="{{ $thread->id }}" href="#" data-toggle="modal" data-target="#thread_delete" class="btn btn-danger pull-right delete_thread">Delete Thread</a>
		@endif
	</div>

	@if(Auth::check() && Auth::user()->isAdmin())

		<div class="modal fade" id="thread_delete" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<h4 class="modal-title">Delete Thread</h4>
					</div>
					
					<div class="modal-body">
						<h3>Are you sure you want to delete this Thread?</h3>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<a href="#" type="button" class="btn btn-primary" id="btn_delete_thread">Delete</a>
					</div>
				</div>
			</div>
		</div>

	@endif

	<div class="well well-sm">
		<h1>{{ $thread->title }}</h1>
		<hr>
		<p><small>By: {{ $author }} on {{ $thread->created_at->diffForHumans() }}</small></p>
		@if(Auth::user() == $thread->author)
			<a href="{{ URL::route('forum-showedit-thread', $thread->id) }}" class="edit">Edit Thread</a>
		@endif
		<p>{{ nl2br(BBCode::parse($thread->body)) }}</p>
		
	</div>
	<div class="well well-sm">
		<div class="clearfix">
			@if(count($thread->comments()->get()))
				<h4>Comments</h4>
				<hr>
				@foreach ($thread->comments()->get() as $comment)
						<p><small>By: {{ $comment->author->username }} on {{ $comment->created_at->diffForHumans() }}</small></p>
						<div class="interaction">
	                      	@if(Auth::user() == $comment->author)
	                            <a href="{{ URL::route('forum-show-comment', $comment->id) }}" class="edit">Edit</a>
	                        @endif
	                    </div>
						<p>{{ nl2br(BBCode::parse($comment->body)) }}</p>
						<hr>
						@if(Auth::check() && Auth::user()->isAdmin())
							<a id="{{ $comment->id }}" href="#" data-toggle="modal" data-target="#comment_delete" class="btn btn-danger btn-xs pull-right delete_comment">Delete</a>
						@endif
				@endforeach

			@else
				<h4>No comments yet</h4>
			@endif
			<div id="posted_comment"></div>
		</div>
	</div>
	

	@if(Auth::check() && Auth::user()->isAdmin())

		<div class="modal fade" id="comment_delete" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<h4 class="modal-title">Delete Comment</h4>
					</div>
					
					<div class="modal-body">
						<h3>Are you sure you want to delete this Comment?</h3>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<a href="#" type="button" class="btn btn-primary" id="btn_delete_comment">Delete</a>
					</div>
				</div>
			</div>
		</div>
	@endif

	@if(Auth::check())
		<form id="forum_comment" action="{{ URL::route('forum-store-comment', $thread->id) }}" method= "post">
			<div class="form-group">
				<label for="body">Comment: </label>
				<textarea class="form-control" name="body" id="body"></textarea>
			</div>
			{{ Form::token() }}
			<div class="form-group">
				<input type="button" id="post_comment" value="Post Comment" class="btn btn-primary">
			</div>
		</form>
	@endif
@stop

@section('javascript')
	@parent
	<script type="text/javascript" src="/js/app.js"></script>
@stop