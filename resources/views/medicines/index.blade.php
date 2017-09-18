@extends('layouts.base')

@section('content')

<div class="page-title">
	<div class="title_left">
		<h3><i class="fa fa-medkit"></i> Medicamentos</h3>
	</div>
	<div class="title_right">
		<div class="form-group pull-right">
	  		<div class="input-group">
	    		<a class="btn btn-round btn-primary" href="{{ route('medicines.create') }}"> <i class="fa fa-plus"></i> Nuevo Medicamento </a>	
	  		</div>
		</div>
	</div>
</div>
<medicines></medicines>

@endsection