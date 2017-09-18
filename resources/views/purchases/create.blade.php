@extends('layouts.base')

@section('content')

<div class="page-title">
	<div class="title_left">
		<h3><i class="fa fa-shopping-cart"></i> COMPRAS</h3>
	</div>
	<div class="title_right">
		<div class="form-group pull-right">
	  		<div class="input-group">
	    		<a class="btn btn-round btn-primary" href="{{ route('purchases.list') }}"> <i class="fa fa-list"></i>Lista de Compras</a>	
	  		</div>
		</div>
	</div>

</div>
<div class="clearfix"></div>
<addpurchase></addpurchase>
@endsection