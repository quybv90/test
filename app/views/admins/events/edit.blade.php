@extends('layouts.admin')
<h1>Create event</h1>
@section('content')
{{ Form::model($event, array('method' => 'PATCH', 'route' =>
 array('admin.events.update', $event->id))) }}
  <table class="table">
    <tr>
        <td>
            {{ Form::label('title', 'Title:') }}
        </td>
        <td>
            {{ Form::text('title', $event->title) }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('content', 'Content:') }}
        </td>
        <td>
            {{ Form::textarea('content', $event->content, array('data-provide' => 'markdown', 'id' => 'some-textarea', 'rows' => '25', 'cols' => "70")) }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('started_date', 'Start date:') }}
        </td>
        <td>
            {{ Form::text('started_date', date("Y/m/d", strtotime($event->started_date)), array('class' => 'datepicker')) }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('end_date', 'End date:') }}
        </td>
        <td>
            {{ Form::text('end_date', date("Y/m/d", strtotime($event->end_date)), array('class' => 'datepicker')) }}
        </td>
    </tr>
    <tr>
        <td>
            {{ Form::label('status', 'Status') }}
        </td>
        <td>
            <div class="col-sm-8">
                {{ Form::radio('status', '1', $event->status == 1) }} Active
                {{ Form::radio('status', $event->status == 0) }} Not Active <br>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            {{ Form::submit('Submit', array('class' => 'btn')) }}
        </td>
    </tr>
{{ Form::close() }}
@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
  </table>
  <script>
  $(function() {
    $('.datepicker').datepicker({
        format: "yyyy/m/d",
    });
    $("#some-textarea").markdown();
  });
</script>
@stop
