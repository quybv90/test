@extends('layouts.visitor')
@section('content')
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Your's clipboad
                    <small>[This is private content]</small>
            </div>
        </div>
           <!-- /.row -->

        <!-- Project One -->
        @if ($leech_photos->count())
        <table class="table table-bordered table-active">
          @foreach($leech_photos as $photo)
            <tr>
                <td class="col-md-5">
                    {{ link_to_route('leech_photos.show', $photo->title, array($photo->id), array('class' => 'btn btn-primary')) }}
                </td>
                <td class="col-md-7">
                   {{ $photo->description }}
                </td>
                <td>
                    {{ Form::open(array('method' => 'DELETE', 'route' => array('leech_photos.destroy', $photo->id))) }} 
                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }} 
                    {{ Form::close() }}
                </td>
            </tr>
          @endforeach
        </table>
        @else
          There are no posts
        @endif
        <h3>qr code for this page</h3>
        <div id="qr_code"></div>
        <!-- /.row -->
        <hr>

        <!-- Pagination -->
        <div style="text-align: center">{{ $leech_photos->links(); }}</div>
        <!-- /.row -->
@stop
