@extends('layouts.master')

@section('head')
	@parent
	<title>biST Forum</title>
@stop

@section('content')

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="clearfix">
						<h3 class= "panel-title pull-left">Last Posts</h3>
					</div>
				</div>
				<div class="panel-body panel-list-group">
					<div class="list-group">
						@foreach($latestPost as $latest)
							<a href="{{ URL::route('forum-thread', $latest->id) }}" class="list-group-item">{{$latest->title}}<small class= "panel-body panel-list-group pull-right"> Created on {{ $latest->created_at->diffForHumans() }}</small></a>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		
		@if(Auth::check() && Auth::user()->isAdmin())
			<div>
				<a href="#" class="btn btn-success" data-toggle="modal" data-target = "#group_form">Add Group</a>
			</div>
	 	@endif
  		
  		<div class="col-md-12">
			@foreach($groups as $group)

					@if(Auth::check() && Auth::user()->isAdmin())	
						<div class="clearfix">
							<a id="add-category-{{ $group->id }}" href="#" data-toggle="modal" data-target="#category_modal" class="btn btn-success btn-xs pull-right new_category">New Category</a>
			  				<a id="{{ $group->id }}" href="#" data-toggle="modal" data-target="#group_delete" class="btn btn-danger btn-xs pull-right delete_group">Delete</a>
						</div>
					@endif

				<div class="panel panel-default">
			  		<div class="panel-heading">
			  			@if(Auth::check() && Auth::user()->isAdmin())
			  			
			  			<div class="clearfix">

			  				<h3 class= "panel-title pull-left">{{ $group->title }}<h3  class= "panel-title pull-right"><em> Created on {{ $group->created_at->diffForHumans() }} </em></h3></h3>
			  				
			  			</div>
			  			@else
			  			<div class="clearfix">
			  				<h3 class= "panel-title pull-left">{{ $group->title }}<h3  class= "panel-title pull-right"><em> Created on {{ $group->created_at->diffForHumans() }} </em></h3></h3>
			  			</div>
			  			@endif 
			  		</div>
			 		
					<div class="panel-body panel-list-group">
			    		<div class="list-group">
			    			@foreach($categories as $category)
			    				@if($category->group_id == $group->id)
			    				 <a href="{{ URL::route('forum-category', $category->id) }}" class="list-group-item">{{ $category->title }} <h3  class= "panel-title pull-right"><small> Created on {{ $category->created_at->diffForHumans() }} </small></h3></a>
			    				@endif
			    			@endforeach
			  			</div>
			  		</div>
				</div>

			@endforeach
		</div>


@if(Auth::check() && Auth::user()->isAdmin())
	<div class="modal fade" id="group_form" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">New Group</h4>
				</div>
				
				<div class="modal-body">
					<form id="target_form"  method="post" action="{{ URL::route('forum-store-group') }}">
						<div class="form-group {{ ($errors->has('group_name')) ? ' has-error ' : '' }}">
							<label for="group_name">Group Name</label>
							<input type="text" id="group_name" name="group_name" class="form-control">
							@if($errors->has('group_name'))
								<p>{{ $errors->first('group_name') }}</p>
							@endif 
						</div>
						{{ Form::token() }}
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal" id="form_submit">Save</button>
					
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="category_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">New Category</h4>
				</div>
				
				<div class="modal-body">
					<form id="category_form"  method="post">
						<div class="form-group {{ ($errors->has('category_name')) ? ' has-error ' : '' }}">
							<label for="category_name">Categoty Name</label>
							<input type="text" id="category_name" name="category_name" class="form-control">
							@if($errors->has('category_name'))
								<p>{{ $errors->first('category_name') }}</p>
							@endif 
						</div>
						{{ Form::token() }}
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal" id="category_submit">Save</button>
					
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="group_delete" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Delete Group</h4>
				</div>
				
				<div class="modal-body">
					<h3>Are you sure you want to delete this group?</h3>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<a href="#" type="button" class="btn btn-primary" id="btn_delete_group">Delete</a>
					
				</div>
			</div>
		</div>
	</div>
	

@endif

@stop

@section('javascript')
	@parent
		<script type="text/javascript" src="/js/app.js"></script>
	@if(Session::has('modal'))
	<script type="text/javascript">
		$("{{ Session::get('modal') }}").modal('show');
	</script>
	@endif

	@if(Session::has('category-modal') && Session::has('group_id'))
	<script type="text/javascript">
		$("#category_form").prop('action', "/forum/category/{{ Session::get('group_id') }}/new");
		$("{{ Session::get('category-modal') }}").modal('show');
	</script>
	@endif
@stop

