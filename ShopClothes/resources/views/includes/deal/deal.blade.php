@php
//lấy tên phương tiện từ constants
$typeVehicle = config("constants.vehicle");
@endphp
<div class="col-sm-12 col-md-12 col-xs-12 package clear-padding transport">
	<div class="header_home row clear_margin">
		<a href="{{ route('web::index_deal') }}"><h3><img src="{{ asset('img/icon/muanew.png') }}"> MUA BÁN</h3></a>
	</div>
	<div class="row block_search_cargooffer clear_margin">
		<form action="{{ route('web::searchDeal') }}" method="POST" novalidate="novalidate" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="col-xs-12 col-md-12 col-md-12 clear-padding">
				<div class="col-xs-12 col-sm-12 col-md-4 clear-padding">
					<input class="form-control" id="autocomplete" type="text" name="deal_vehicles" placeholder="thương hiệu" value="{{isset($search_info) ? $search_info["deal_vehicles"] : null}}">
                </div>
				<div class="col-xs-12 col-sm-12 col-md-3 clear-padding">
					<select name="deal_price" id="deal_price" class="form-control">
						<option value="" selected>Màu sắc</option>
						<option value="" >Tất cả</option>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3 clear-padding">
					<select name="deal_price" id="deal_price" class="form-control">
						<option value="" selected>Size</option>
						<option value="">Tất cả</option>
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
			@component('components.home.deal', ["data" => $deal])
			@endcomponent
		</div>
	</div>
</div>
@section('javascripts')
<script type="text/javascript">
	$('#search_cargooffer').click(function(e){
		var diachi = $('#noi_nhan').val();
		var deal_price = $('#deal_price').val();
		var loaipt = $('#autocomplete').val();
		if(diachi == "" && deal_price == ""  && loaipt == "")
		{
			e.preventDefault();
			var url = $('#url').val();
			window.location.assign(url)
		}
	});
</script>
@component('components.master.jquery_autocomplete',["data" => $typeVehicle])@endcomponent
@endsection
{{-- {{$deal->links('pagination.default')}} --}}