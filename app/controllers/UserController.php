<?php

class UserController extends BaseController {
  // protected $layout = "layout";

   public function __construct() {
     $this->beforeFilter('csrf', array('on'=>'post'));
   }
    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'HomeController@showWelcome');
    |
    */

    // public function showWelcome()
    // {
    //     return View::make('hello');
    // }
  public function index()
  {
    $users = User::paginate(10);
    return View::make('users.index', compact('users'));
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return View::make('users.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $input = Input::all();
    $validation = Validator::make($input, User::$rules);

    if ($validation->passes())
    {
      $input['password'] = Hash::make(Input::get('password'));
      User::create($input);
      return Redirect::route('users.index');
    }
    return Redirect::route('users.create')
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
    $user = User::find($id);
    $user_hot_posts = Post::userHotPosts($id);
    $user_posts = Post::userApprovedPosts($id)->paginate(10);
    if(Helper::correctUser($id, $id)){
      $user_posts = Post::userAllPosts($id)->paginate(10);
    }
    return View::make('users.show', compact('user', 'user_hot_posts', 'user_posts'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
    {
        $user = User::find($id);
        if (is_null($user))
        {
            return Redirect::route('users.index');
        }
        return View::make('users.edit', compact('user'));
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
    $user = User::find($id);
    $validation = Validator::make($input, User::$update_rules);
    if ($validation->passes())
    {
        $destinationPath = '';
        $filename        = '';

        if (Input::hasFile('avatar_url')) {
          $file            = Input::file('avatar_url');
          $destinationPath = public_path().'/img/';
          $filename        = Str::slug(str_random(6) . '_' . explode(".", $_FILES['avatar_url']['name'])[0]) . '.' . explode("/", $_FILES['avatar_url']['type'])[1];
          $uploadSuccess   = $file->move($destinationPath, $filename);
          $input['avatar_url'] = '/img/' . $filename;
        } else {
          $input['avatar_url'] = $user->avatar_url;
        }
        $input['password'] = Hash::make(Input::get('password'));
        $user->update($input);
        return Redirect::route('users.show', $id);
    }
    return Redirect::route('users.edit', $id)
      ->withInput()
      ->withErrors($validation)
      ->with('message', 'There were validation errors.');
    }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $user = User::find($id);
    $user->delete();
    return Redirect::route('users.index')
      ->with("message", " deleted");
  }

  public function post_create()
  {

    $validator = Validator::make(Input::all(), User::$rules);
    if ($validator->passes()) {
        $destinationPath = '';
        $filename        = '';

        if (Input::hasFile('avatar_url')) {
            $file            = Input::file('avatar_url');
            $destinationPath = public_path().'/img/';
            $filename        = Str::slug(str_random(6) . '_' . explode(".", $_FILES['avatar_url']['name'])[0]) . '.' . explode("/", $_FILES['avatar_url']['type'])[1];
            $uploadSuccess   = $file->move($destinationPath, $filename);
        }

        $user = new User;
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        $user->avatar_url = '/img/' . $filename;
        $user->password = Hash::make(Input::get('password'));

        $user->save();
        Auth::attempt( array('email' => $user->email, 'password' => Input::get('password')) );
        return Redirect::to('login')->with('message', 'Thanks for registering!');
    } else {
        return Redirect::to('signup')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
    }
  }
}
