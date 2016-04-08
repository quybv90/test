@extends('layouts.new_view')
@section('content')
    <div id="content">
      <article class="post clearfix">
      	<div class="row" id="top-buttons">
      	    <div class="col-lg-12">
      	        <h1 class="page-header">
      	            <div class="text-center">
      	              <h1>Bảng xếp hạng</h1>
      	            </div>
      	        </h1>
      	    </div>
      	</div>
        <ul class="nav nav-tabs" style="margin-left: 0px;">
          <li class="{{ ($od == '') ? 'active' : ''}}"><a href="{{route('static_page', ['filename' => 'bang-xep-hang'])}}">Tat ca</a></li>
          <li class="{{ ($od == 'monthy') ? 'active' : ''}}"><a href="{{route('static_page', ['filename' => 'bang-xep-hang', 'od' => 'monthy'])}}">Thang</a></li>
          <li class="{{ ($od == 'weekly') ? 'active' : ''}}"><a href="{{route('static_page', ['filename' => 'bang-xep-hang', 'od' => 'weekly'])}}">Tuan</a></li>
        </ul>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
                  <tr>
                    <th>Xếp hạng</th>
                    <th>Ảnh đại diện</th>
                    <th>Tên người dùng</th>
                    <th>Số bài đăng</th>
                    <th>Điểm</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($all_ranked_users as $index => $user)
                <?php 
                	if (Input::get('page')) {
                		$p = 20*(intval(Input::get('page')) - 1) + ($index + 1);
                	}else{
                		$p = ($index + 1);
                	}
                ?>
                  <tr>
                    <td class="text-center">
                    	@if($p == 1)
	                    	<img src="{{ asset('images/gold.png') }}">
	                    	<div class="ranking">{{$p}}</div>
	                    @elseif ($p == 2)
	                    	<img src="{{ asset('images/silver.png') }}">
	                    	<div class="ranking">{{$p}}</div>
	                    @elseif ($p == 3)
	                    	<img src="{{ asset('images/bronze.png') }}">
	                    	<div class="ranking">{{$p}}</div>
                    	@else
                    		<div class="ranking ranking-info">{{$p}}</div>
                    	@endif
                    </td>
                    <td class="text-center" >
                    	<a target="_blank" href="{{ route('users.show', ['id' => $user->id]) }}">
                    		<img style="width: 100px; height: 100px" src="{{ $user->avatar_url }}" alt="{{$user->name}}" id="{{$user->name}}"/>
                    	</a>
                    </td>
                    <td class="text-center">
                    	<div class="ranking-info">
                    		<a target="_blank" href="{{ route('users.show', ['id' => $user->id]) }}">{{$user->name}}</a>
                    	</div>
                	</td>
                    <td class="text-center"><div class="ranking-info">{{ User::find($user->id)->posts->count()}}</div></td>
                    <td class="text-center"><div class="ranking-info red">{{$user->total_likes}} 
                      <i class="glyphicon glyphicon-heart-empty" style="color: red;"></i></div></td>
                  </tr>
                @endforeach
                </tbody>
          </table>
        </div>
        <div class="text-center">
        	<?php echo $all_ranked_users->links('pagination::slider-3'); ?>
        </div>
      </article>
    <!-- /.post -->
    </div>
    @include('posts.related_post')
<!-- /#content --> 
@stop