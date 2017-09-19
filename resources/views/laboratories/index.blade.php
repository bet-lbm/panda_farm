@extends('layouts.base')

@section('content')

<div class="page-title">
	<div class="title_left">
		<h3><i class="fa fa-flask"></i>Laboratorios</h3>
	</div>
	<div class="title_right">
		<div class="form-group pull-right">
	  		<div class="input-group">
	    		<a class="btn btn-round btn-primary" href="{{ route('laboratories.create') }}"> <i class="fa fa-plus"></i> Nuevo Laboratorio </a>	
	  		</div>
		</div>
	</div>
</div>
<laboratories></laboratories>

@endsection