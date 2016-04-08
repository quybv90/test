@extends('layouts.visitor')
@section('content')
<hr class="">
<div class="container target">
    <div class="row">
        <div class="col-sm-10">
             <h1 class="">{{$user->name}}</h1>
            @if (Auth::check() && Helper::correctUser(Auth::user()->id, $user->id))
              {{ HTML::link('logout', Lang::get("common.logout"), array('class' => 'btn btn-success')) }}
              {{ link_to_route('users.edit', Lang::get("common.settings"), array(Auth::user()->id), array('class' => 'btn btn-info')) }}
            @endif
<br>
        </div>
      <div class="col-sm-2"><a href="/users/{{$user->id}}" class="pull-right"><img title="{{$user->name}}" class="img-circle img-responsive" src="{{$user->avatar_url}}" style="width: 165px; height: 174px;"></a>

        </div>
    </div>
  <br>
    <div class="row">
        <div class="col-sm-3">
            <!--left col-->
            <ul class="list-group">
                <li class="list-group-item text-muted" contenteditable="false">{{Lang::get("users.profile")}}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">{{Lang::get("users.created_at")}}</strong></span><div class="text-danger">{{$user->created_at->format('Y-m-d')}}</div></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">{{Lang::get("users.last_update")}}</strong></span><div class="text-danger">{{$user->updated_at->format('Y-m-d')}}</div></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">{{Lang::get("users.user_name")}}</strong></span><div class="text-danger">{{$user->name}}</div></li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i>

                </div>
                <div class="panel-body"><a href="http://fun4v.com" class="">fun4v.com</a>

                </div>
            </div>
          
            <ul class="list-group">
                <li class="list-group-item text-muted">{{Lang::get("users.active")}} <i class="fa fa-dashboard fa-1x"></i></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">{{Lang::get("users.total_posts")}}</strong></span><a href="">{{$user->posts->count()}} {{Lang::get("posts.post_times")}}</a></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">{{Lang::get("users.unapprove")}}</strong></span><a href="">{{$user->unApprovedPosts->count()}} {{Lang::get("posts.post_times")}}</a></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">{{Lang::get("users.liked")}}</strong></span><a href="">{{$user->countLiked->count()}} {{Lang::get("posts.times")}}</a></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">{{Lang::get("users.was_liked")}}</strong></span><a href="">{{Like::userWasLiked($user->id)->count()}} {{Lang::get("posts.times")}}</a></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">{{Lang::get("users.disliked")}}</strong></span><a href="">{{$user->countDisLiked->count()}} {{Lang::get("posts.times")}}</a></li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-heading">{{Lang::get("common.plugin_title")}}</div>
                <div class="fb-page" data-href="https://www.facebook.com/fun4v" data-width="290" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/fun4v"><a href="https://www.facebook.com/fun4v">Góc thư giãn.</a></blockquote></div></div>
            </div>
        </div>
        <!--/col-3-->
        <div class="col-sm-9" contenteditable="false" style="">
            <!-- <div class="panel panel-default">
                <div class="panel-heading">{{$user->name}}</div>
                <div class="panel-body"> Yeu gai dep ^^</div>
            </div> -->
            <div class="panel panel-default target">
                <div class="panel-heading" contenteditable="false">{{Lang::get("users.user_hot_posts")}} {{$user->name}}</div>
                <div class="panel-body">
                  <div class="row">
                    @foreach($user_hot_posts as $post)
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
                            {{$post->title}}
                          </p>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                <div class="panel panel-default">
                  <div class="panel-heading">{{Lang::get("users.user_posts_title")}} {{$user->name}}</div>
                  <div class="panel-body">
                    @if ($user_posts->count())
                      @foreach($user_posts as $post)
                        <div class="row" id="post-{{ $post->id }}">
                            <div class="col-md-7">
                              @if ($post->status == "New")
                              <div class="status-new"></div>
                              @endif
                                @if($post->category == "photo")
                                    {{ ViewHelper::displayOnePhoto($post->content, $post->title, $post->id)  }}
                                @elseif($post->category == "video")
                                    <iframe align="center" style="width:90%; height:350px"  src="{{ViewHelper::convertUrl($post->content)}}"  
                  frameborder="yes" scrolling="yes" name="myIframe" id="myIframe"></iframe>
                                @endif
                            </div>
                            <div class="col-md-5">
                                <a href='{{ route("post_show", ["slug" => Str::slug($post->title), "id" => $post->id]) }}'><h3>{{ $post->title }}</h3></a>
                                <h5 class="posted_by" >{{Lang::get("common.posted_by")}} {{ link_to_route('users.show', $post->user->name, array($post->user->id)) }}
                                    {{ViewHelper::time_elapsed_string($post->created_at)}} {{Lang::get("common.time_ago")}}</h5>
                                <div>
                                    {{ViewHelper::fbLikeButton($post)}}
                                    {{ViewHelper::fbShareButton($post)}}
                                </div>
                                <span class="glyphicon glyphicon-eye-open post-view">{{ $post->total_views() }}</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="glyphicon glyphicon-comment post-view"><span class="fb-comments-count" data-href="{{ $post->url }}"></span></span>
                                <!-- like -->
                                <div class="rateWrapper"><span class="like rate rateUp" id="{{$post->id}}" data-item="{{$post->id}}">
                                <span class="rateUpN">Ngon {{ViewHelper::likeNumber($post->true_likes()->count())}}</span></span>
                                <span class="disLike rate rateDown" data-item="{{$post->id}}" id="dis_{{$post->id}}">
                                <span class="rateDownN">Ko ngon {{ViewHelper::likeNumber($post->disLikes()->count())}}</span></span></div><br />
                                <!-- end like -->
                                <!-- <p>{{ $post->description }}</p> -->
                            </div>
                        </div>
                        <hr>
                      @endforeach
                      <div id="paging">
                        {{ $user_posts->links('pagination.only_next') }}
                      </div>
                    @else
                      @if (Auth::check() && Auth::user()->id == $user->id)
                        Bạn chưa đăng bài nào, Hãy nhấn vào {{ link_to_action('PostController@create', 'Đây', array(), array('class' => '')) }} để đăng bài nhé
                      @else
                        Không có bài đăng nào!!!
                      @endif
                    @endif
                  </div>
                </div>
        </div>
        </div>
</div>
@stop
