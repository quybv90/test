<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
            Session::set('return_url', Request::path());
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

// Route::filter('auth.customize', function ($route, $request) {
//     $user = $request->getUser();
//     $password = $request->getPassword();
//     if ($user == 'box-ae' && $password == 'battu')
//     {
//         return;
//     }
//     $headers = array('WWW-Authenticate' => 'Basic');
//     return new  \Symfony\Component\HttpFoundation\Response('Invalid credentials.', 401, $headers);
// });

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

Route::filter('correctUser', function($route,$response,$model)
{
  if($model == 'Message') {
    $id = Route::input(strtolower(str_plural($model)));
    $user = Message::find($id)->to_id;
    if(!Helper::correctUser($id, $user)){
      return Redirect::route('messages.index')->with('message','Bạn không có quyền truy cập!!!');
    }
  } else {
  	$id = Route::input(strtolower(str_plural($model)));
  	$user = $model::find($id)->user_id;
  	if(!Helper::correctUser($id, $user)){
  	  return Redirect::route('posts.index')->with('message','Bạn không có quyền truy cập!!!');
  	}
  }
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/
Route::filter('csrf', function()
{
	$token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
