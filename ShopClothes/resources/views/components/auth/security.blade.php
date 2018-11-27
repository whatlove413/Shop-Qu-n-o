<li class="non-list-style"><a data-toggle='modal' data-target='#security' id="btn-post-news" title="Chính sách bảo mật của SharingEconomy" rel="nofollow">Chính sách bảo mật</a></li>
<!-- Modal -->
<div id="security" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Chính sách bảo mật</h4>
        </div>
        <div class="modal-body footer-rule">
            @php
            echo $constant['chinh-sach-bao-mat']->constant_content;
            @endphp
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        </div>
    </div>
</div>
</div>