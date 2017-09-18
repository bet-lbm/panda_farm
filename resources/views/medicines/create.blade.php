@extends('layouts.base')

@section('content')

<div class="page-title">
	<div class="title_left">
		<h3><i class="fa fa-medkit"></i>Medicamentos</h3>
	</div>
	<div class="title_right">
		<div class="form-group pull-right">
	  		<div class="input-group">
	    		<a class="btn btn-round btn-primary" href="{{ route('medicines.list') }}"> <i class="fa fa-list"></i> Lista de Medicamento </a>	
	  		</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<addmedicine></addmedicine>
@endsection