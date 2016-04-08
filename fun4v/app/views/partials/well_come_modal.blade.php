<div class="modal fade" id="well_come_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:500px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Xin chào bạn đã đến với Fun4v</h4>
      </div>
      <div class="modal-body">
        <div class="text-center">
            <h3 class="">Xinh quá ha? . Nhấn nút </h3>
              <div class="content-center" style="margin-left: 36%;">
              <!-- like -->
                <div class="rateWrapper"><span class="rate rateUp" id="" data-item="">
                <span class="rateUpN">{{Lang::get('common.like_label')}}</span></span>
                <span class="rate rateDown" data-item="" id="">
                <span class="rateDownN">{{Lang::get('common.dislike_label')}}</span></span></div><br />
              <!-- end like -->
              </div>
            <h3 class="">Để bình chọn cho bức ảnh nhé</h3>
              
        </div>
      </div>
      <div class="modal-footer">
        {{ HTML::link('login', Lang::get("common.log_in"), array('class' => 'btn btn-primary')) }}
        <div class="btn btn-danger" id="enter">Bỏ qua</div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $("#enter").on('click', function(){
      $("#well_come_modal").modal('hide');
    });
    function isSmartPhone() {
      if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        return true;
      } else{
        return false;
      }
    }
    var is_smart = isSmartPhone();
    var loged_in = '{{ Auth::check() }}';
    if (!is_smart && !loged_in ){
      setTimeout(function(){
          $("#well_come_modal").modal('show');
      }, 5000);
    }
</script>
<style type="text/css">
  .modal-backdrop {
     /*background-color: #0000CC;*/
  }
</style>
