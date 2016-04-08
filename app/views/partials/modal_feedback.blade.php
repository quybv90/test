<script src="//cdn.ckeditor.com/4.5.3/standard/ckeditor.js"></script>
<div class="modal fade" id="modal_feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Đóng góp ý kiến cho website</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(array('route' => 'messages.store')) }}
          <table class="table">
            <tr>
                <td>
                    {{ Form::label('title', 'Tiêu đề:') }}
                </td>
                <td>
                    {{ Form::text('title','', array('size' => '55')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('content', 'Nội dung phản hồi:') }}
                </td>
                <td>
                    {{ Form::textarea('content', '', array('class' => 'ckeditor', 'rows' => '15', 'cols' => "70")) }}
                    {{ Form::hidden('stage', 'feedback') }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    {{ Form::submit('Gửi phản hồi', array('class' => 'btn btn-primary')) }}
                </td>
            </tr>
          </table>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>