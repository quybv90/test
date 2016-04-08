<?php

class MessageController extends BaseController {
   public function __construct() {
     $this->beforeFilter('csrf', array('on'=>'post'));
     $this->beforeFilter('auth', array('only'=>array('show', 'edit', 'update', 'destroy')));
     $this->beforeFilter('correctUser:Message',array('only'=>array('show', 'edit', 'update', 'destroy')));
     $this->beforeFilter('checkAdmin', array('only'=>array('edit', 'update')));
     $this->current_user = Auth::user();
   }

  public function index()
  { $hot_images = Post::hotImages('');
    $hot_videos = Post::hotVideos('');
    $messages = Auth::user()->receiveMessages()->orderBy('updated_at', 'desc')->Paginate(10);
    return View::make('messages.index', compact('messages', 'hot_images', 'hot_videos'));
  }
  public function create()
  {
    if (Post::createdToday(Auth::user()->id)->count() > 4 && Auth::user()->type != "Admin"){
      return Redirect::route('posts.index')
      ->with("message", Lang::get("common.limited_posts"));
    }
    $category_session =  Session::get('category');
    $category = isset($category_session) ? (string)$category_session : "false";
    return View::make('posts.create', compact('category'));
  }

  public function show($id)
  {
    $hot_images = Post::hotImages('');
    $hot_videos = Post::hotVideos('');
    $message = Message::find($id);
    $message->markAsReaded();
    return View::make('messages.show', compact('message', 'hot_images', 'hot_videos'));
  }

  public function destroy($id)
  {
    $post = Post::find($id);
    $post->delete();
    return Redirect::route('posts.index')
      ->with("message", " deleted");
  }

  public function store()
  {
    $input = Input::all();
    $validation = Validator::make($input, Message::$rules);

    if ($validation->passes())
    {
      Message::create($input);
      
      return Redirect::back()->with('message', 'CẢm ơn ý kiến đóng góp của bạn!!!');
    }
    return Redirect::back()->with('message', "Góp ý của bạn chưa được gửi vì chưa nhập đủ thông tin");
  }
}
