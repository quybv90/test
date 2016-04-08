<?php
namespace admin;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller;
use Input;
use Request;
use Redirect, Validator;
use \Fun4vEvent as Event;
use Illuminate\Support\Str as Str;
class EventController extends BaseAdminController {
  public function index()
  {
    $myevents = Event::Paginate(10);
    return View::make('admins/events.index', compact('myevents'));
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return View::make('admins/events.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $input = Input::all();
    $validation = Validator::make($input, Event::$rules);

    if ($validation->passes())
    {
      Event::create($input);
      return Redirect::route('admin.events.index');
    }
    return Redirect::route('admin.events.create')
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
    $event = Event::find($id);
    return View::make('admins/events.show', compact('event'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
    {
        $event = Event::find($id);
        if (is_null($event))
        {
            return Redirect::route('admins/events.index');
        }
        return View::make('admins/events.edit', compact('event'));
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
    $validation = Validator::make($input, Event::$rules);
    if ($validation->passes())
    {
        $event = Event::find($id);
        $event->update($input);
        return Redirect::route('admin.events.show', $id);
    }
    return Redirect::route('admin.events.edit', $id)
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
    $event = Event::find($id);
    $event->delete();
    return Redirect::route('admins/events.index')
      ->with("message", " deleted");
  }
}
