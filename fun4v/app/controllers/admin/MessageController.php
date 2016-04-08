<?php
namespace admin;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller;
use Input;
use Request;
use Redirect, Validator;
use \Message as Message;
use Illuminate\Support\Str as Str;
class MessageController extends BaseAdminController {
  public function index()
  {
    $st = Input::get('st');
    if($st == null){
      $st = 'unread';
    }
    $messages = Message::where('stage', '=', $st)->orderBy('updated_at', 'desc')->Paginate(10);
    return View::make('admins/messages.index', compact('messages', 'st'));
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return View::make('admins/messages.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $input = Input::all();
    $validation = Validator::make($input, Message::$rules);

    if ($validation->passes())
    {
      if($input['to_id'] == 'all'){
        $to_users = \User::lists('id');// - [\Auth::user()->id];
        foreach ($to_users as $id) {
          $input['to_id'] = $id;
          Message::create($input);
        }
      }else{
        Message::create($input);
      }
      
      return Redirect::route('admin.messages.index');
    }
    return Redirect::route('admin.messages.create')
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
    $message = Message::find($id);
    return View::make('admins/messages.show', compact('message'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
    {
        $message = Message::find($id);
        if (is_null($message))
        {
            return Redirect::route('admins/messages.index');
        }
        return View::make('admins/messages.edit', compact('message'));
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
    $validation = Validator::make($input, Message::$rules);
    if ($validation->passes())
    {
        $message = Message::find($id);
        $message->update($input);
        return Redirect::route('admin.messages.show', $id);
    }
    return Redirect::route('admin.messages.edit', $id)
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
    $message = Message::find($id);
    $message->delete();
    return Redirect::route('admins/messages.index')
      ->with("message", " deleted");
  }
}
