@extends('layouts.master')

@section('head')
	
	@parent

	<title>Search Results</title>

@stop

@section('content')
	
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="clearfix">
						<h3 class= "panel-title pull-left">Search Results</h3>
					</div>
				</div>
				@if(!$results)
				<div class="panel-body panel-list-group">
					<div class="list-group">
						<a href="#" class="list-group-item">No results found!</a>
					</div>
				</div>
					
				@else
				<div class="panel-body panel-list-group">
					<div class="list-group">
						@foreach($results as $result)
							<a href="{{ URL::route('forum-thread', $result->id) }}" class="list-group-item">{{substr($result->body,0,35)}}...<strong>Click to view in detail.</strong></a>
						@endforeach
					</div>
				</div>
				@endif
			</div>
		</div>

@stop