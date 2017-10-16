@extends('layouts.base')

@section('content')
	<div class="page-title">
		<div class="title_left">
			<h2 class="col-md-6 text-danger"><i class="fa fa-warning"></i> ANULAR VENTA </h2>
		</div>
	</div>
	<div class="clearfix"></div>
	@can('cancel_sales')
		<salescancel></salescancel>
	@else
		<div class="clearfix"></div>
		<div class="alert alert-danger alert-dismissible fade in text-center">
			<strong>Usuario NO autorizado,</strong>
			para anular comprobantes de pago.
		</div>
	@endcan
@endsection