<?php

class SessionsController extends \BaseController {
 protected $layout = "layout";
  /**
   * Display a listing of the resource.
   * GET /sessions
   *
   * @return Response
   */
  public function index()
  {
    //
  }
 
  /**
   * Show the form for creating a new resource.
   * GET /sessions/create
   *
   * @return Response
   */
  public function create()
  {
    if(Auth::check()){
      return Redirect::to('/')->with('message', 'Your are logged in');
    }else{
      return View::make('sessions.create');
    }
  }
 
  /**
   * Store a newly created resource in storage.
   * POST /sessions
   *
   * @return Response
   */
  public function store()
  {
    $session_url = Session::get('return_url');
    $return_url = isset($session_url) ? Session::get('return_url') : '/';
    Session::forget('return_url');
    $input = Input::all();
    $remember = (Input::has('remember')) ? true : false;
    $attempt = Auth::attempt( array('email' => $input['email'], 'password' => $input['password']), $remember);
    
    if($attempt) {
      return Redirect::to($return_url);
    } else {
      return Redirect::to('login')->with('message', 'Your username/password combination was incorrect.');
    }
  }
 
  /**
   * Display the specified resource.
   * GET /sessions/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }
 
  /**
   * Show the form for editing the specified resource.
   * GET /sessions/{id}/edit
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    //
  }
 
  /**
   * Update the specified resource in storage.
   * PUT /sessions/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    //
  }
 
  /**
   * Remove the specified resource from storage.
   * DELETE /sessions/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy()
  {
    Auth::logout();
    Session::flush();
    return Redirect::to('login')->with('message', 'Your are now logged out!');;
  }
  public function signup() {
    return View::make('sessions.signup');
  }
}
