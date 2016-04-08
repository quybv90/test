<article class="post clearfix">
<div class="panel-heading" contenteditable="false" style="background-color: #ABA8A8;">{{Lang::get("posts.may_you_also_like")}}</div>
<div class="panel-body">
  <div class="row">
    @foreach($hot_images as $post)
    <div class="col-md-4">
      <div class="thumbnail">
        <a href="{{ route('post_show', ['slug' => Str::slug($post->title), 'id' => $post->id]) }}">
          @if ($post->category == "photo")
          <img src="{{ ViewHelper::getFirstImage($post->content) }}" alt="{{$post->title}}" id="{{$post->title}}" style="width: 240px; height: 174px;"/>
          @elseif ($post->category == "video")
          <img src="{{ViewHelper::mqThumbVideo($post->content)}}" alt="{{$post->title}}" id="{{$post->title}}" style="width: 240px; height: 174px;"/>
          @endif
        </a>
        <!-- <img alt="300x200" src="http://lorempixel.com/600/200/people"> -->
        <div class="caption">
          <span class="glyphicon glyphicon-eye-open post-view">{{ $post->total_views() }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <span class="glyphicon glyphicon-comment post-view"><span class="fb-comments-count" data-href="{{ $post->url }}"></span></span>
          <p>
            <h6 class="ellipsis">{{ link_to_route('post_show', $post->title, ['slug' => Str::slug($post->title), 'id' => $post->id]) }}</h6>
          </p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</article>