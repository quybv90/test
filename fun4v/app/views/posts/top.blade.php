@extends('layouts.new_view')
@section('content')
  @if($active_event->count())
    <div class="row" id="top-buttons">
        <div class="col-lg-12">
            <h1 class="page-header">
                <div class="text-right">
                  {{ $active_event[0]->content }}
                </div>
            </h1>
        </div>
    </div>
  @endif
  <div id="content">
  @if ($posts->count())
    @foreach($posts as $index => $post)
      <article class="post clearfix">
        <header>
          <a href='{{ route("post_show", ["slug" => Str::slug($post->title), "id" => $post->id]) }}'>
            <h4 class="post-title break-wword">[{{($post-> category == "photo") ? "Photo" : "Clip" }}] <b>{{ $post->title }}</b></h4>
          </a>
          <div class="header-info">
            <div class="header-left">
              <h6 class="posted_by" >
                {{Lang::get("common.posted_by")}} {{ link_to_route('users.show', $post->user->name, array($post->user->id)) }}
                                    {{ViewHelper::time_elapsed_string($post->created_at)}} {{Lang::get("common.time_ago")}}
              </h6>

              <div>
                  {{ViewHelper::fbLikeButton($post)}}
                  {{ViewHelper::fbShareButton($post)}}
              </div>

              <span class="glyphicon glyphicon-eye-open post-view">{{ $post->total_views() }}</span>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <span class="glyphicon glyphicon-comment post-view"><span class="fb-comments-count" data-href="{{ $post->url }}"></span></span>
            </div>
            <div class="header-right">
              <h6><b>Vote để ủng hộ cho tác giả nhé :)</b></h6>
              <!-- like -->
              <div class="rateWrapper"><span class="like rate rateUp" id="{{$post->id}}" data-item="{{$post->id}}">
              <span class="rateUpN">{{Lang::get('common.like_label')}} {{ViewHelper::likeNumber($post->true_likes()->count())}}</span></span>
              <span class="disLike rate rateDown" data-item="{{$post->id}}" id="dis_{{$post->id}}">
              <span class="rateDownN">{{Lang::get('common.dislike_label')}} {{ViewHelper::likeNumber($post->disLikes()->count())}}</span></span></div><br />
              <!-- end like -->
            </div>
          </div>
        </header>
        <figure class="post-image"> 
          @if($post->category == "photo")
              {{ ViewHelper::displayOnePhoto($post->content, $post->title, $post->id)  }}
          @elseif($post->category == "video")
              <iframe align="center" style="width:90%; height:350px"  src="{{ViewHelper::convertUrl($post->content)}}"  
  frameborder="yes" scrolling="yes" name="myIframe" id="myIframe"> </iframe>
          @endif
        </figure>

      </article>
    <!-- /.post -->
      @if ($index == 0)
          <hr >
          <div><b><img src="{{ asset('images/like-icon.png') }}" alt="Like"> Like <a href="https://www.facebook.com/fun4v" target="_blank">Fun4v trên Facebook</a> để được quay tay nhiều hơn</b></div>
          <br>
          <div class="fb-like" data-href="https://www.facebook.com/fun4v" data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>
      @endif
      <hr />
      @endforeach
      <!-- TO TOP -->
      @include('partials.to_top')
      
      <div id="paging">
        {{ $posts->links('pagination.only_next') }}
      </div>
      <hr />
    @else
      
    @endif
  </div>
<!-- /#content --> 


  <aside id="sidebar">

    <section class="widget">
      <h4 class="widgettitle"><img src="{{ asset('images/icon-ranking.gif') }}"></img> {{Lang::get("common.ranked_users")}}</h4>
      <ul>
        @foreach($ranked_users as $user)
          <hr />
          <div class="ranked-users">
            <a target="_blank" href="{{ route('users.show', ['id' => $user->id]) }}">
              <img src="{{ $user->avatar_url }}" alt="{{$user->name}}" id="{{$user->name}}" class="user-ranked-avatar"/></a>
              <div class="">
                  <div><a target="_blank" href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->name }}</a></div>
                  <span style="color: red">{{ $user->total_likes }} <i class="glyphicon glyphicon-heart-empty" style="color: red;"></i></span>
              </div>
          </div>
        @endforeach
        <hr />
      </ul>
      <div class="text-right"><a href="{{route('static_page', ['filename' => 'bang-xep-hang'])}}"> Hiển thị thêm </a></div>
    </section>
    <!-- /.widget -->

    <section class="widget clearfix">
      <h4 class="widgettitle"><img src="{{ asset('images/icon-hot.gif') }}"></img>{{Lang::get("posts.hot_photos")}}</h4>
      @foreach($hot_images as $image)
        <hr />
        <div class="hot-images-top">
        <a target="_blank" href="{{ route('post_show', ['slug' => Str::slug($image->title), 'id' => $image->id]) }}">
          <img src="{{ ViewHelper::getFirstImage($image->content) }}" alt="{{$image->title}}" id="{{$image->title}}"/></a>
          <div class="right-des">
              <p class="ellipsis">{{ link_to_route('post_show', $image->title, ['slug' => Str::slug($image->title), 'id' => $image->id]) }}</p>
              <span class="glyphicon glyphicon-eye-open post-view">{{ $image->total_views() }}</span>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <span class="glyphicon glyphicon-comment post-view"><span class="fb-comments-count" data-href="{{ $image->url }}"></span></span>
          </div>
      </div>
      @endforeach

    </section>
    <!-- /.widget -->

    <div id="sticky-anchor"></div>
    <div id="last-widget">
      <section class="widget clearfix">
        <h4 class="widgettitle plugin-area-top plugin-text">Like <a href="https://www.facebook.com/fun4v">Fan page của Fun4v.com</a> bạn nhé !</h4>
        <div class="fb-page" data-href="https://www.facebook.com/fun4v" data-width="300" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/fun4v"><a href="https://www.facebook.com/fun4v">Góc thư giãn.</a></blockquote></div></div>
      </section>
      <section class="widget clearfix">
        <div class="fb-page"><img src="{{asset('images/quang-cao.jpg')}}" /></div>
      </section>
    </div>
    <!-- /.widget -->
            
  </aside>
<!-- /#sidebar -->
@stop
