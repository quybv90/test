@extends('layouts.visitor')
@section('content')
    <!-- Page Content -->
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{$leech_photo->title}}
                <br>
                <small>{{$leech_photo->description}}</small>
                <div class="text-right">
                    {{ link_to_route('leech_photos.edit', 'Edit', array($leech_photo->id), array('class' => 'btn btn-danger')) }}
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="qr_container text-right">
            <h3 class="">qr code for this page</h3>
            <div id="qr_code"></div>
        </div>
        <!-- Project One -->
            <div class="row">
                <div class="text-center" style="width:70%">
                   {{ ViewHelper::displayPhoto($leech_photo)  }}
                </div>
            </div>
            <hr>
        <!-- /.row -->

        <hr>
        <!-- /.row -->
@stop
<style type="text/css">
    .qr_container {
        position: fixed;
        margin-left: 800px;
    }
</style>
