@if( session('success') )
    <div class="alert alert-success" style="margin-top: 1%">
	  <strong>{{session('success')}}!</strong>
	</div>
@endif
