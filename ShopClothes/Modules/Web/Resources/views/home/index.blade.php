@extends('layouts.frontendMaster')
@section('content')
<div class="home">
    <!-- Đây là menu top trên cùng của trang -->
    @component('components.master.menuTop',["category" => $category])
    @endcomponent
    <div class="row clear_margin slider_home">
        @include('includes.home.slide')
    </div>
    <div class="clear-padding transport row block_service clear_margin top-5">
        @include('includes.deal.homeDeal')
    </div>
</div>
@endsection

