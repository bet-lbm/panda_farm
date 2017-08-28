@extends('layouts.base')

@section('content')

<div class="page-title">
	<div class="title_left">
		<h3><i class="fa fa-shopping-cart"></i> COMPRAS</h3>
	</div>

	<div class="title_right">
		<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
	  		<div class="input-group">
	    		<input type="text" class="form-control" placeholder="Search for...">
	    		<span class="input-group-btn">
	      			<button class="btn btn-default" type="button">Go!</button>
	    		</span>
	  		</div>
		</div>
	</div>
</div>
<purchases></purchases>

@endsection