<div id="map" class="{{isset($detail) ? "detail-page" : null}} col-sm-6 col-md-6 col-xs-12 clear-padding"></div>
<script type="text/javascript">
	// draw direction between two location
	function showDirections(diembatdau,diemketthuc,map) {
		var sampleRequest = {
			origin: diembatdau,
			destination: diemketthuc,
			travelMode: google.maps.TravelMode.DRIVING,
			unitSystem: google.maps.UnitSystem.METRIC,
		};
		var directionsService = new google.maps.DirectionsService();
		//tạo image marker
		var icons = {
			start: new google.maps.MarkerImage(
		   // URL
		   '{{ asset('img/avatar/gpssharing.png') }}',
		    // (width,height)
		    new google.maps.Size(27, 43),
	        // The origin point (x,y)
	        new google.maps.Point(0, 0),
	        // The anchor point (x,y)
	        new google.maps.Point(13, 38)),

			end: new google.maps.MarkerImage(
		   // URL
		   '{{ asset('img/avatar/gpssharing.png') }}',
		    // (width,height)
		    new google.maps.Size(27, 43),
	        // The origin point (x,y)
	        new google.maps.Point(0, 0),
	        // The anchor point (x,y)
	        new google.maps.Point(13, 38))
		};
		directionsService.route(sampleRequest, function(response, status) {
			var message = '';
			var errorDiv;
			if (status === 'OK') {
				directionsDisplay.setDirections(response);
				var leg = response.routes[ 0 ].legs[ 0 ];
				makeMarker( leg.start_location, icons.start);
				makeMarker( leg.end_location, icons.end);
			} else {
				message =
				'Something went wrong getting directions. ' +
				'Please, try your request again.';
				console.log(message);
			}
		});
		function makeMarker( position, icon, title ) {
			new google.maps.Marker({
				position: position,
				map: map,
				icon: icon,
				animation: google.maps.Animation.DROP
			});
		}
	}
	function myMap() {
		var mapCanvas = document.getElementById("map");
		var myCenter = new google.maps.LatLng(16.461109,107.570183);
		var mapOptions = {center: myCenter, zoom: 6, mapTypeId: google.maps.MapTypeId.ROADMAP,};
		var map = new google.maps.Map(mapCanvas,mapOptions);
		directionsDisplay = new google.maps.DirectionsRenderer({
			preserveViewport: true,
			draggable: true,
			suppressMarkers: true,
		});

		directionsDisplay.setMap(map);
		@switch($exchange)
			//set map hàng vận chuyển
			@case(1)
			@if ( $data && $data->cargo_offer_receipt_place_lat != null && $data->cargo_offer_delivery_place_lat != null)
			var noiden = new google.maps.LatLng({{$data->cargo_offer_receipt_place_lat}},{{$data->cargo_offer_receipt_place_lng}});
			var noigiao = new google.maps.LatLng({{$data->cargo_offer_delivery_place_lat}},{{$data->cargo_offer_delivery_place_lng}});
			showDirections(noiden,noigiao,map);
			@else
			@foreach ($data as $item)
			@if($item->cargo_offer_receipt_place_lat != null && $item->cargo_offer_delivery_place_lat != null)
			var noiden_{{$item->cargo_offer_id}} = new google.maps.LatLng({{$item->cargo_offer_receipt_place_lat}},{{$item->cargo_offer_receipt_place_lng}});
			var noigiao_{{$item->cargo_offer_id}} = new google.maps.LatLng({{$item->cargo_offer_delivery_place_lat}},{{$item->cargo_offer_delivery_place_lng}});
			var mark_noiden_{{$item->cargo_offer_id}} = new google.maps.Marker({
				position: noiden_{{$item->cargo_offer_id}},
				icon:'{{ asset('img/avatar/gpssharing.png') }}',
				animation: google.maps.Animation.DROP
			});
			var mark_giao_{{$item->cargo_offer_id}} = new google.maps.Marker({
				position: noigiao_{{$item->cargo_offer_id}},
				icon:'{{ asset('img/avatar/gpssharing.png') }}',
				animation: google.maps.Animation.DROP
			});
			mark_noiden_{{$item->cargo_offer_id}}.setMap(map);
			mark_giao_{{$item->cargo_offer_id}}.setMap(map);
			@endif
			@endforeach
			@endif
			@break
		    //set map phương tiện vận chuyển
		    @case(2)
		    @if ( $data && $data->vehicle_open_departure_place_lat != null && $data->vehicle_open_destination_place_lat != null)
		    var noikhoihanh = new google.maps.LatLng({{$data->vehicle_open_departure_place_lat}},{{$data->vehicle_open_departure_place_lng}});
		    var noiden = new google.maps.LatLng({{$data->vehicle_open_destination_place_lat}},{{$data->vehicle_open_destination_place_lng}});
		    showDirections(noikhoihanh,noiden,map);
		    @else
		    @foreach ($data as $item)
		    @if($item->vehicle_open_departure_place_lat != null && $item->vehicle_open_destination_place_lat != null)
		    var noikhoihanh_{{$item->vehicle_open_id}} = new google.maps.LatLng({{$item->vehicle_open_departure_place_lat}},{{$item->vehicle_open_departure_place_lng}});
		    var noiden_{{$item->vehicle_open_id}} = new google.maps.LatLng({{$item->vehicle_open_destination_place_lat}},{{$item->vehicle_open_destination_place_lng}});
		    var mark_noikhoihanh_{{$item->vehicle_open_id}} = new google.maps.Marker({
		    	position: noikhoihanh_{{$item->vehicle_open_id}},
		    	icon:'{{ asset('img/avatar/gpssharing.png') }}',
		    	animation: google.maps.Animation.DROP
		    });
		    var mark_noiden_{{$item->vehicle_open_id}} = new google.maps.Marker({
		    	position: noiden_{{$item->vehicle_open_id}},
		    	icon:'{{ asset('img/avatar/gpssharing.png') }}',
		    	animation: google.maps.Animation.DROP
		    });
		    mark_noikhoihanh_{{$item->vehicle_open_id}}.setMap(map);
		    mark_noiden_{{$item->vehicle_open_id}}.setMap(map);
		    @endif
		    @endforeach
		    @endif
		    @break
		    //set map kho
		    @case(3)
		    @if ( $data && $data->warehouse_address_lat != null )
		    var diachi = new google.maps.LatLng({{$data->warehouse_address_lat}},{{$data->warehouse_address_lng}});
		    var mark_diachi = new google.maps.Marker({
		    	position: diachi,
		    	icon:'{{ asset('img/avatar/gpssharing.png') }}',
		    	animation: google.maps.Animation.DROP
		    });
		    map.setZoom(15);
		    map.panTo(mark_diachi.position);
		    mark_diachi.setMap(map);
		    @else
		    @foreach ($data as $item)
		    @if($item->warehouse_address_lat != null)
		    var diachi_{{$item->warehouse_id}} = new google.maps.LatLng({{$item->warehouse_address_lat}},{{$item->warehouse_address_lng}});
		    var mark_diachi_{{$item->warehouse_id}} = new google.maps.Marker({
		    	position: diachi_{{$item->warehouse_id}},
		    	icon:'{{ asset('img/avatar/gpssharing.png') }}',
		    	animation: google.maps.Animation.DROP
		    });
		    mark_diachi_{{$item->warehouse_id}}.setMap(map);
		    @endif
		    @endforeach
		    @endif
		    @break
		    //set map dịch vụ
		    @case(4)
		    @if ($data && $data->service_place_lat != null)
		    var dichvu = new google.maps.LatLng({{$data->service_place_lat}},{{$data->service_place_lng}});
		    var mark_dichvu = new google.maps.Marker({
		    	position: dichvu,
		    	icon:'{{ asset('img/avatar/gpssharing.png') }}',
		    	animation: google.maps.Animation.DROP
		    });
		    map.setZoom(15);
		    map.panTo(mark_dichvu.position);
		    mark_dichvu.setMap(map);
		    @else
		    @foreach ($data as $item)
		    @if($item->service_place_lat != null)
		    var dichvu_{{$item->service_id}} = new google.maps.LatLng({{$item->service_place_lat}},{{$item->service_place_lng}});

		    var mark_dichvu_{{$item->service_id}} = new google.maps.Marker({
		    	position: dichvu_{{$item->service_id}},
		    	icon:'{{ asset('img/avatar/gpssharing.png') }}',
		    	animation: google.maps.Animation.DROP
		    });
		    mark_dichvu_{{$item->service_id}}.setMap(map);
		    @endif
		    @endforeach
		    @endif
		    @break
		    //set map mua bán
		    @case(5)
		    @if ( $data && $data->deal_view_place_lat != null)
		    var muaban = new google.maps.LatLng({{$data->deal_view_place_lat}},{{$data->deal_view_place_lng}});
		    var mark_muaban = new google.maps.Marker({
		    	position: muaban,
		    	center: {lat: {{$data->deal_view_place_lat}}, lng: {{$data->deal_view_place_lng}} },
		    	icon:'{{ asset('img/avatar/gpssharing.png') }}',
		    	animation: google.maps.Animation.DROP
		    });
		    map.setZoom(15);
		    map.panTo(mark_muaban.position);
		    mark_muaban.setMap(map);
		    @else
		    @foreach ($data as $item)
		    @if($item->deal_view_place_lat != null)
		    var muaban_{{$item->deal_id}} = new google.maps.LatLng({{$item->deal_view_place_lat}},{{$item->deal_view_place_lng}});
		    var mark_muaban_{{$item->deal_id}} = new google.maps.Marker({
		    	position: muaban_{{$item->deal_id}},
		    	icon:'{{ asset('img/avatar/gpssharing.png') }}',
		    	animation: google.maps.Animation.DROP
		    });
		    mark_muaban_{{$item->deal_id}}.setMap(map);
		    @endif
		    @endforeach
		    @endif
		    @break
		    //set map tuyển dụng
		    @case(6)
		    @if ( $data && $data->recruitment_address_lat != null)
		    var tuyendung = new google.maps.LatLng({{$data->recruitment_address_lat}},{{$data->recruitment_address_lng}});
		    var mark_tuyendung = new google.maps.Marker({
		    	position: tuyendung,
		    	center: {lat: {{$data->recruitment_address_lat}}, lng: {{$data->recruitment_address_lng}} },
		    	icon:'{{ asset('img/avatar/gpssharing.png') }}',
		    	animation: google.maps.Animation.DROP
		    });
		    map.setZoom(15);
		    map.panTo(mark_tuyendung.position);
		    mark_tuyendung.setMap(map);
		    @else
		    @foreach ($data as $item)
		    @if($item->recruitment_address_lat != null)
		    var tuyendung_{{$item->recruitment_id}} = new google.maps.LatLng({{$item->recruitment_address_lat}},{{$item->recruitment_address_lng}});
		    var mark_tuyendung_{{$item->recruitment_id}} = new google.maps.Marker({
		    	position: tuyendung_{{$item->recruitment_id}},
		    	icon:'{{ asset('img/avatar/gpssharing.png') }}',
		    	animation: google.maps.Animation.DROP
		    });
		    mark_tuyendung_{{$item->recruitment_id}}.setMap(map);
		    @endif
		    @endforeach
		    @endif
		    @break

		    @default
		    Default case...
		    @endswitch
		}
	</script>

