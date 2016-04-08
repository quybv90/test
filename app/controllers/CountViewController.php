<?php
class CountViewController extends BaseController {

  public function dump_view() {
    $count_view = [];
    $alls = Post::all();
    foreach($alls as $post) { 
        $count_view["post_id"] = $post->id; 
        $count_view["total_view"] = 0;
        $a = CountView::create($count_view);
    }
    return json_encode($count_view);
  }
}
