<a data-toggle='modal' data-target='#block_post_news' id="btn-post-newss" title="điều khoản dịch vụ Sharing Economy" rel="nofollow">điều khoản và điều kiện</a>
<!-- Modal -->
<div id="block_post_news" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Điều khoản và điều kiện</h4>
        </div>
        <div class="modal-body">
            @php
                echo $constant['dieu-khoan-va-dich-vu']->constant_content;
            @endphp
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        </div>
    </div>
</div>
</div>