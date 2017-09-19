@extends('layouts.base')

@section('content')

<div class="page-title">
	<div class="title_left">
		<h3><i class="fa fa-users"></i>Clientes</h3>
	</div>
	<div class="title_right">
		<div class="form-group pull-right">
	  		<div class="input-group">
	    		<a class="btn btn-round btn-primary" href="{{ route('clients.list') }}"> <i class="fa fa-list"></i> Lista de Cliente </a>	
	  		</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<addclient></addclient>
@endsection