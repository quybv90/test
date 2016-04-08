<div class="modal fade" id="modal_warning_qr_code" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Warning</h4>
      </div>
      <div class="modal-body">
        <div class="text-center">
            <h3 class="">QrCode</h3>
            <div id="qr_code_modal"></div>
            <h3 class="">Trang này có thể chứa nội dung nguy hiểm.</h3>
            <h3 class="">bạn nên sử dụng QR-code và vào bằng điệ thoại..</h3>
        </div>
      </div>
      <div class="modal-footer">
        {{link_to_route('index', 'Quay Lai','', array('class'=>'btn btn-primary'))}}
        <div class="btn btn-danger" id="enter">Xem Luon</div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        url = window.location.href;  
        $('#qr_code_modal').qrcode({width: 120,height: 120, text: url});
    });
    $("#enter").on('click', function(){
      $("#modal_warning_qr_code").modal('hide');
    });
</script>
<style type="text/css">
  .modal-backdrop {
     background-color: #0000CC;
  }
</style>
