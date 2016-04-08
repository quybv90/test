<?php
namespace api\v1;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller;
use Input;
use Request;
use Redirect, Validator;
use \Post as Post;
class PostController extends Controller {

  public function index()
  { 
    if (Input::get('type') == "New"){
      $posts = Post::newPosts()->paginate(3);
    }else{
      $posts = Post::paginate(20);
    }
    return View::make('admins.posts.index', compact('posts'));
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return View::make('admins.posts.create');
  }
  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $input = Input::all();
    $validation = Validator::make($input, Post::$rules);

    if ($validation->passes())
    {
      Post::create($input);
      return Redirect::route('admins.posts.index');
    }
    return Redirect::route('admins.posts.create')
        ->withInput()
        ->withErrors($validation)
        ->with('message', 'There were validation errors.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $post = Post::find($id);
    $posts = Post::all();
    return json_encode($post);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
    {
        $post = Post::find($id);
        if (is_null($post))
        {
            return Redirect::route('admins.posts.index');
        }
        return View::make('admins.posts.edit', compact('post'));
    }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $input = Input::all();
    if (Request::ajax()) {
      $post = Post::find($id);
      $post->status = Input::get('status');
      $post->update();
      return json_encode($id);
    }else{
      $validation = Validator::make($input, Post::$rules);
      if ($validation->passes())
      {
          $post = Post::find($id);
          $post->update($input);
          return Redirect::route('admin.posts.show', $id);
      }
      return Redirect::route('admins.posts.edit', $id)
        ->withInput()
        ->withErrors($validation)
        ->with('message', 'There were validation errors.');
      }
    }
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $post = Post::find($id);
    $post->delete();
    return Redirect::route('admin.posts.index')
      ->with("message", "Deleted");
  }
}

