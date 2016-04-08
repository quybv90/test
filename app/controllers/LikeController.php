<?php

class LikeController extends BaseController {

  public function like()
  {
    if(!Auth::check()){
      return json_encode(Lang::get("common.login_require_message"));
    }
    $like = new Like();
    $like->user_id = Auth::user()->id;
    $like->post_id = Input::get('post_id');
    $post = Post::find($like->post_id);
    $like->like_value = Input::get('like_value');
    if($like->liked($like->user_id, $like->post_id) && Auth::user()->type != "Admin"){
      return json_encode("Bạn đã bình chọn rồi!");
    }else{
        $like->save();
        return json_encode($post->true_likes()->count());
    }
  }

  public function disLike()
  {
    if(!Auth::check()){
      return json_encode(Lang::get("common.login_require_message"));
    }
    $like = new Like();

    $like->user_id = Auth::user()->id;
    $like->post_id = Input::get('post_id');
    $post = Post::find($like->post_id);
    $like->like_value = Input::get('like_value');
    if($like->liked($like->user_id, $like->post_id) && Auth::user()->type != "Admin"){
      return json_encode(Lang::get("common.already_vote"));
    }else{
        $like->save();
        return json_encode($post->disLikes()->count());
    }
  }
}
