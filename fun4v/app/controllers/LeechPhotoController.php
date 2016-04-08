<?php

class LeechPhotoController extends BaseController {
   public function __construct() {
     $this->beforeFilter('csrf', array('on'=>'post'));
     $this->beforeFilter('auth', array('only'=>array('create', 'edit', 'store')));
     // $this->beforeFilter('correctUser:LeechPhoto',array('only'=>array('show')));
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
    $leech_photos = LeechPhoto::paginate(20);
    return View::make('leech_photos.index', compact('leech_photos'));
  }
  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $input = Input::all();
    $validation = Validator::make($input, LeechPhoto::$rules);

    if ($validation->passes())
    {
      LeechPhoto::create($input);
      return Redirect::route('leech_photos.index')->with('message', 'Saved to Clipboad');
    }
    return Redirect::route('leech_photos.index')
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
    $leech_photo = LeechPhoto::find($id);
      return View::make('leech_photos.show', compact(array('leech_photo')));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
    {
        $leech_photo = LeechPhoto::find($id);
        if (is_null($leech_photo))
        {
            return Redirect::route('lecch_photos.index')->with('message', "Edited");
        }
        return View::make('leech_photos.edit', compact('leech_photo'));
    }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $leech_photo = LeechPhoto::find($id);

    $input = Input::all();
    $validation = Validator::make($input, LeechPhoto::$rules);
    if ($validation->passes())
    {
        $leech_photo->update($input);
        return Redirect::route('leech_photos.show', $id);
    }
    return Redirect::route('leech_photos.edit', $id)
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
    $leech_photo = LeechPhoto::find($id);
    $leech_photo->delete();
    return Redirect::route('leech_photos.index')
      ->with("message", " deleted");
  }
}
