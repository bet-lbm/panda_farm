@extends('layouts.base')

@section('content')

<div class="page-title">
	<div class="title_left">
		<h3><i class="fa fa-flask"></i>Laboratorio</h3>
	</div>
	<div class="title_right">
		<div class="form-group pull-right">
	  		<div class="input-group">
	    		<a class="btn btn-round btn-primary" href="{{ route('laboratories.list') }}"> <i class="fa fa-list"></i> Lista de Laboratorio </a>	
	  		</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
	@can('add_laboratory')
		<addlaboratory></addlaboratory>
	@else
		<div class="clearfix"></div>
		<div class="alert alert-danger alert-dismissible fade in text-center">
			<h5>NO TIENES PERMISOS PARA AGREGAR LABORATORIO</h5>
		</div>
	@endcan

@endsection