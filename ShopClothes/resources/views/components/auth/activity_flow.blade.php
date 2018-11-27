<li class="non-list-style"><a data-toggle='modal' data-target='#activity_flow' id="btn-post-news" title="Quy chế hoạt động của SharingEconomy" rel="nofollow">Quy chế hoạt động</a></li>
<!-- Modal -->
<div id="activity_flow" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Quy chế hoạt động</h4>
        </div>
        <div class="modal-body footer-rule">
             @php
             echo $constant['quy-che-hoat-dong']->constant_content;
             @endphp
        </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
    </div>
</div>
</div>
</div>