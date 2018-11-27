<a data-toggle='modal' data-target='#badpost' class="bad_post_block col-xs-5 col-sm-5 col-md-3" title="Báo tin không hợp lệ" rel="nofollow">Báo tin không hợp lệ</a>
<!-- Modal -->
<div id="badpost" class="modal fade badpost" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Báo cáo tin không hợp lệ</h4>
			</div>
			<div class="modal-body col-xs-12 col-sm-12 col-md-12">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<h4> THÔNG TIN CỦA BẠN VÀ LÍ DO BÁO CÁO TIN NÀY</h4>
					<div class="col-md-12 form_post">
						<input type="hidden" id="bad_post_post_id" value="{{$bad_post_post_id}}">
						<input type="hidden" id="bad_post_post_object" value="{{$bad_post_post_object}}">
						<div class="form-group">
							<label class="control-label">Họ và tên<span class="required"> * </span></label>
							<input id="bad_post_name" type="text" name="contact_name" value="{!! old('contact_name') !!}" class="form-control" title="Họ tên" placeholder="Nhập họ tên">
						</div>
						<div class="form-group">
							<label class="control-label">Email</label>
							<input id="bad_post_email" type="email" name="contact_email" value="{!! old('contact_email') !!}" class="form-control" title="Email" placeholder="Nhập email">
						</div>
						<div class="form-group">
							<label class="control-label">Số điện thoại</label>
							<input id="bad_post_mobile" type="text" name="contact_phone" value="{!! old('contact_phone') !!}" class="form-control" title="Số điện thoại" placeholder="Nhập số điện thoại">
						</div>
						<div class="form-group">
							<label for="contact_content">Nội dung<span class="required"> * </span></label>
							<span><textarea id="bad_post_content" class="form-control" rows="5" name="contact_content" placeholder="Nhập nội dung">{!! old('contact_content') !!}</textarea></span>
						</div>
						<input type="hidden" name="contact_type" value="GOPY">
					</div>
					<button class="btn btn-primary nextBtn btn-lg pull-right badpost_button"> Gửi<i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></button>
					<input type="hidden" value="{{ route('web::badPost') }}">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>
@section('javascripts')
<script type="text/javascript">
	$('.badpost_button').click(function(e) {
		e.preventDefault();
		var url = $(this).next().val();
		var bad_post_post_id = $('#bad_post_post_id').val();
		var bad_post_post_object = $('#bad_post_post_object').val();
		var bad_post_name = $('#bad_post_name').val();
		var bad_post_mobile = $('#bad_post_mobile').val();
		var bad_post_email = $('#bad_post_email').val();
		var bad_post_content = $('#bad_post_content').val();
		$.ajax({
			url: url,
			method: 'get',
			data: { "bad_post_post_id": bad_post_post_id,"bad_post_post_object": bad_post_post_object,"bad_post_name": bad_post_name,"bad_post_mobile": bad_post_mobile,"bad_post_email": bad_post_email,"bad_post_content": bad_post_content},
			success:function(response){
				swal("Gửi báo cáo thành công!", {
					icon: "success",
				});
				$('button.close').click();
				var bad_post_name = $('#bad_post_name').val("");
				var bad_post_mobile = $('#bad_post_mobile').val("");
				var bad_post_email = $('#bad_post_email').val("");
				var bad_post_content = $('#bad_post_content').val("");
			},
			error: function(data){
				swal({
					title: "Thông báo",
					text: "Vui lòng nhập đầy đủ thông tin",
					icon: "warning",
				})
			}
		});
	});
</script>
@endsection
