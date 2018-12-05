@extends('layouts.frontendMaster')
@section('content')
<!-- Đây là menu top trên cùng của trang -->
@component('components.master.menuTop',["muaban" => true])
@endcomponent
<div class="col-md-12 col-xs-12 clear-padding" style="padding-top: 2%;">
    @include('includes.home.slide')
</div>
<div class="clear-padding vehicle col-sm-12">
	@include('includes.deal.deal',["name"=>$name])
</div>
@endsection