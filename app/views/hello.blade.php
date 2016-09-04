@extends('layouts.master')

@section('head')
	@parent
	<title>Home Page</title>

@stop

@section('content')

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>
 
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="/images/banner.jpg" alt="...">
      <div class="carousel-caption">
          <h3></h3>
      </div>
    </div>
    <div class="item">
      <img src="http://www.freewebheaders.com/wordpress/wp-content/gallery/computer/digital-tablet-with-business-plan-and-cup-of-coffee-web-header.jpg" alt="...">
      <div class="carousel-caption">
          <h3></h3>
      </div>
    </div>
    <div class="item">
      <img src="/images/banner2.jpg" alt="...">
      <div class="carousel-caption">
          <h3></h3>
      </div>
    </div>
  </div>
 
  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div> <!-- Carousel -->

@if(Auth::check() && Auth::user())  
    <div class="jumbotron">
    <h1>Welcome to BRACU Forum!</h1>
    <p>Please join everyone to improve our Customer Service at BRAC University. Here we will share our day to day experiences with each other.</p>
    <p><a class="btn btn-success btn-lg" href="{{ URL::route('forum-home') }}" role="button">Explore Now!</a></p>
  </div>
@else
  <div class="jumbotron">
    <h1>Welcome to BRACU Forum!</h1>
    <p>Please join everyone to improve our Customer Service at BRAC University. Here we will share our day to day experiences with each other.</p>
    <p><a class="btn btn-success btn-lg" href="{{ URL::route('getCreate') }}" role="button">Register Now!</a></p>
  </div>
@endif
	
@stop

