<aside id="sidebar">
  <section class="widget">
    <h4 class="widgettitle"><img src="{{  asset('images/icon-hot.gif') }}"></img>{{Lang::get("posts.hot_photos")}}</h4>
    <ul>
      @foreach($hot_images as $image)
      <hr>
          <a href="{{ route('post_show', ['slug' => Str::slug($image->title), 'id' => $image->id]) }}">
            <img src="{{ ViewHelper::getFirstImage($image->content) }}" alt="{{$image->title}}" title="{{$image->title}}" id="{{$image->title}}"/></a>
            <div>
                <span class="glyphicon glyphicon-eye-open post-view">{{ $image->total_views() }}</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-comment post-view"><span class="fb-comments-count" data-href="{{ $image->url }}"></span></span>
            </div>
          <h6 class="ellipsis">{{ link_to_route('post_show', $image->title, ['slug' => Str::slug($image->title), 'id' => $image->id]) }}</h6>
        @endforeach
      <hr />
    </ul>
  </section>

  <section class="widget">
    <h4 class="widgettitle">{{Lang::get("posts.hot_videos")}}</h4>
    <ul>
      <div class="hot-videos">
        <div class="releated-content" id="test">
          @foreach($hot_videos as $video)
          <div class="videoItems">
              <div> <a href="{{ route('post_show', ['slug' => Str::slug($video->title), 'id' => $video->id]) }}">
                <img src="{{ViewHelper::mqThumbVideo($video->content)}}" title="{{$video->title}}" alt="{{$video->title}}" id="{{$video->title}}"/></a></div>
              <div class="play-image"><img src="{{ asset('images/play_icon.png') }}" /> </div>
          </div>

                <div>
                    <span class="glyphicon glyphicon-eye-open post-view">{{ $video->total_views() }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-comment post-view"><span class="fb-comments-count" data-href="{{ $video->url }}"></span></span>
                </div>
            <h6 class="ellipsis">{{ link_to_route('post_show', $video->title, ['slug' => Str::slug($video->title), 'id' => $video->id]) }}</h6>
          @endforeach
        </div>
      </div>
    </ul>
  </section>
  <div id="sticky-anchor"></div>
  <section class="widget">
    <h4 class="plugin-area-top plugin-text widgettitle">Like <a href="https://www.facebook.com/fun4v">Fan page của Fun4v.com</a> bạn nhé !</h4>
    <ul>
      <hr>
      <div class="plugin-area1">
        <div class="releated-content">
          <div class="fb-page" data-href="https://www.facebook.com/fun4v" data-width="290" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/fun4v"><a href="https://www.facebook.com/fun4v">Góc thư giãn.</a></blockquote></div></div>
        </div>
      </div>
    </ul>
  </section>
</aside>