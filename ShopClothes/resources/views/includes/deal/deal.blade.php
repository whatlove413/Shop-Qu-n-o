
<div class="col-sm-12 col-md-12 col-xs-12 package clear-padding transport">
	<div class="header_home row clear_margin">
		<a href="{{ route('web::index_deal') }}"><h3><img src="{{ asset('img/icon/muanew.png') }}"> {{$name}}</h3></a>
	</div>
	<div class="row block_search_cargooffer clear_margin">
		<form action="{{ route('web::category') }}" method="get" novalidate="novalidate" enctype="multipart/form-data">
			<div class="col-xs-12 col-md-12 col-md-12 clear-padding">
				<div class="col-xs-12 col-sm-12 col-md-3 clear-padding">
					<input class="form-control" id="autocomplete" type="text" name="keyword" placeholder="từ khóa" value="{{isset($search_info) ? $search_info["deal_vehicles"] : null}}">
                </div>
                    @php
                    $id = Request::all()['category_id'];
                    @endphp
                    <input class="hidden" name="category_id" value="{{$id}}">
                <div class="col-xs-12 col-sm-12 col-md-3 clear-padding">
                    <input class="form-control" id="autocomplete" type="text" name="brand" placeholder="Thương hiệu" value="{{isset($search_info) ? $search_info["deal_vehicles"] : null}}">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3 clear-padding">
                    <input class="form-control" id="autocomplete" type="text" name="color" placeholder="màu" value="{{isset($search_info) ? $search_info["deal_vehicles"] : null}}">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-2 clear-padding">
					<select name="size" id="size" class="form-control">
                        <option value="{{null}}" selected>Tất cả</option>
						<option value="small" >SM</option>
                        <option value="medium" >M</option>
                        <option value="large" >L</option>
						<option value="xlarge" >XL</option>
						<option value="xxlarge" >XXL</option>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-1">
					<button id="search_cargooffer" type="submit"><i class="fa fa-search"></i></button>
				</div>
				<input type="hidden" id="url" value="{{ route('web::index_deal') }}">
			</div>
		</form>
	</div>
	<div class="tab-content block-home-new">
		<div id="package_home" class="tab-pane fade in active">
			@component('components.home.deal', ["data" => $product])
			@endcomponent
		</div>
	</div>
</div>
@section('javascripts')

@component('components.master.jquery_autocomplete',["data" => $typeVehicle])@endcomponent
@endsection
{{-- {{$deal->links('pagination.default')}} --}}