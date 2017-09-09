@extends('layouts.base')

@section('content')

<div class="page-title">
	<div class="title_left">
		<h3><i class="fa fa-cubes"></i> Distribuidores</h3>
	</div>
	<div class="title_right">
		<div class="form-group pull-right">
	  		<div class="input-group">
	    		<a class="btn btn-round btn-primary" href="{{ route('dealers.create') }}"> <i class="fa fa-plus"></i> Nuevo Distribuidor </a>	
	  		</div>
		</div>
	</div>
</div>
<dealers></dealers>

@endsection
