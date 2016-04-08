<?php

class CommentController extends BaseController {
    public function __construct() {
        //$this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('store')));
    }

    public function loadContent() {
        $per_page = Config::get('constants.SHOW_COMMENT_PER_PAGE');
        $page = Input::get('page');
        $prev = $per_page * $page;
        $post_id = Input::get('post_id');
        $post = Post::find($post_id);
        $comments = $post->comments()->orderBy('id', 'DESC')->skip($prev)->take($per_page)->get();
        $html = [];
        foreach($comments as $comment) {
        $html[] = ('<li><div class="commenterImage"><img src =' . asset($comment->user->avatar_url) . ' /></div><div class="commentText"><b style="color:#8b9dc3">' .  $comment->user->name . '</b><p class="">' . nl2br($comment->content) . '</p> <span class="date sub-text">' . ViewHelper::time_elapsed_string($comment->created_at) . ' ago</span></div><hr></li>');
        }
        return json_encode($html);
        //return json_encode($comments);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->post_id = Input::get('post_id');
        $comment->content = Input::get('content');
        $validation = Validator::make($input, Comment::$rules);
            $comment->save();
            return json_encode($comment->content);

    }

}
