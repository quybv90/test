<div class="modal show fade" id="modal_leech_photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Save leech to my clipboad</h4>
      </div>
      <div class="modal-body">
    {{ Form::open(array('route' => 'leech_photos.store')) }}
      <table class="table">
        <tr>
            <td>
                {{ Form::label('title', 'Title:') }}
            </td>
            <td>
                <div class="col-sm-8">
                    {{ Form::text('title', '', array('class' => 'form-control')) }}
                </div>
            </td>
        </tr>
        <tr id="photoTr">
            <td>
                    {{ Form::label('content', 'Content Url:') }}
            </td>
            <td>
                <div class="col-sm-8">
                    {{ Form::textarea('content', '', array('rows' => 8, 'class' => 'form-control', 'id' => 'photo_content')) }}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                {{ Form::label('description', 'Description:') }}
            </td>
            <td>
                <div class="col-sm-8">
                    {{ Form::textarea('description', '', array('class' => 'form-control')) }}
                </div>
            </td>
            {{ Form::hidden('user_id', Auth::user()->id) }}
        </tr>
        <tr>
            <td colspan="2">
                {{ Form::submit('Submit', array('class' => 'btn btn-primary center-block', 'id' => 'submit_form')) }}
            </td>
        </tr>
      </table>
    {{ Form::close() }}
      </div>
    </div>
  </div>
</div>