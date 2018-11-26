@extends('layouts.frontendMaster')
@section('content')
<!-- Đây là menu top trên cùng của trang -->
@component('components.master.menuTop',["muaban" => true])
@endcomponent
<div class="col-md-12 col-xs-12 clear-padding" style="padding-top: 2%;">
    <img class="banner_responsive clear-padding col-md-12 col-xs-12" src={{asset("/img/banner/vanchuyen_full.png")}} style="height:140px">
</div>
<div class="clear-padding vehicle col-sm-12">
	@include('includes.deal.deal')
</div>
@endsection