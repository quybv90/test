<?php

class SocialsController extends BaseController
{

    /**
     * Instantiate a new SocialsController instance.
     * @return void
     */
    protected $viewData;
    protected $currentUser;

    public function __construct()
    {
        //parent::__construct();
        $this->currentUser = Auth::user();
        $this->viewData = [
            'currentUser' => $this->currentUser
        ];
        $this->viewData['title'] = 'Social';
        $this->beforeFilter('auth', [
            'only' => [
                'getIndex',
                'getRevoke',
                'getAuthorize'
            ]
        ]);
    }

    public function getIndex()
    {
        $this->viewData['title'] = trans('messages.user.update_title');
        return View::make('social.index', $this->viewData);
    }

    public function getRevoke($type)
    {
        $this->currentUser->socials()->where('type', $type)->delete();
        return Redirect::action('SocialsController@getIndex');
    }

    public function getAuthorize($type)
    {
        $input = Input::all();
        if (isset($input['code'])) {
            SocialService::connectSocial($type, $input['code'],
                action('SocialsController@getAuthorize', ['type' => $type]));
            list($uid, $email, $name, $link) = SocialService::getSocialUser($type);
            if ($uid) {
                if (Social::where('type', $type)->where('uid', $uid)->count() > 0) {
                    return Redirect::action('SocialsController@getIndex')
                        ->with('message', trans('socials.already_associated'));
                }
                if(!Social::withTrashed()->where('uid', $uid)->restore()) {
                    Social::create([
                        'email' => $email,
                        'uid' => $uid,
                        'link' => $link,
                        'type' => $type,
                        'user_id' => $this->currentUser->id
                    ]);
                }
                return Redirect::action('SocialsController@getIndex')
                    ->with('message', trans('socials.connect_successfully'));
            }
        }
        return Redirect::to(SocialService::getAuthorizedUrl($type,
            action('SocialsController@getAuthorize', ['type' => $type])));
    }

    public function getConnect($type)
    {
        $session_url = Session::get('return_url');
        $return_url = isset($session_url) ? Session::get('return_url') : '/';
        Session::forget('return_url');

        $this->viewData['title'] = 'Connect';
        $this->viewData['type'] = $type;

        list($uid, $email, $name, $link, $avatar) = SocialService::getSocialUser($type);
        $input = [
            'email' => $email,
            'name'  => $name,
            'type'  => $type,
            'avatar_url'    => $avatar,
        ];
        $user = User::create($input);
        if ($user) {
            Social::create([
                'email' => $email,
                'uid' => $uid,
                'link' => $link,
                'type' => $type,
                'user_id' => $user->id,
            ]);
            Auth::loginUsingId($user->id);
        }

        return Redirect::to($return_url);
    }

    public function postConnect()
    {
        $session_url = Session::get('return_url');
        $return_url = isset($session_url) ? Session::get('return_url') : '/';
        Session::forget('return_url');
        $input = Input::all();
        $input['email'] = $input['email'];
        $type = $input['type'];

        $validator = Validator::make($input, User::$rules);
        if ($validator->fails()) {
            return Redirect::action('SocialsController@getConnect', ['type' => $type])
                ->withInput($input)
                ->withErrors($validator);
        }
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        if ($user) {
            list($uid, $email, $name, $link) = SocialService::getSocialUser($type);
            $userSocial = Social::create([
                'email' => $email,
                'uid' => $uid,
                'link' => $link,
                'type' => $type,
                'user_id' => $user->id,
            ]);
            Auth::loginUsingId($user->id);
            //return Redirect::action('PostController@index');
        }

        return Redirect::to($return_url);
        //return Redirect::action('PostController@index');
    }

    public function getConfirm($type)
    {
        $this->viewData['title'] = 'Confirm';
        $this->viewData['type'] = $type;

        list($uid, $email, $name, $link) = SocialService::getSocialUser($type);

        $user = User::where('email', $email)->first();
        if ($user) {
            $this->viewData['user'] = $user;
            $this->viewData['socialName'] = $name;
            $this->viewData['socialLink'] = $link;
            return View::make('social.confirm', $this->viewData);
        }

        return Response::view('errors.500', [], 500);
    }

    public function postConfirm()
    {
        $session_url = Session::get('return_url');
        $return_url = isset($session_url) ? Session::get('return_url') : '/';
        Session::forget('return_url');
        $input = Input::all();
        $input['email'] = $input['email'];
        $type = $input['type'];

        $validator = Validator::make($input, User::authRules('email'));
        if ($validator->fails()) {
            return Redirect::action('SocialsController@getConfirm', ['type' => $type])
                ->withInput($input)
                ->withErrors($validator);
        }
        if (!User::validate($input, 'email')) {
            return Redirect::action('SocialsController@getConfirm', ['type' => $type])
                ->withInput($input)
                ->with('message', trans('messages.user.incorrect_password'));
        }

        list($uid, $email, $name, $link) = SocialService::getSocialUser($type);

        $user = User::where('email', $email)->first();
        if ($user) {
            $userSocial = Social::create([
                'email' => $email,
                'uid' => $uid,
                'link' => $link,
                'type' => $type,
                'user_id' => $user->id
            ]);
            $userId = $user->id;
            $user->name = $input['name'];
            $user->save();

            Auth::loginUsingId($userId);
        }

        return Redirect::to($return_url);
        //return Redirect::action('SessionsController@create');
    }

    public function getFacebook()
    {
        $input = Input::all();
        if (isset($input['code'])) {
            SocialService::connectSocial(Social::FACEBOOK, $input['code']);
            $social = SocialService::getSocialUser(Social::FACEBOOK);
            return SocialService::authenticate(Social::FACEBOOK, $social);
        } else {
            return Redirect::to(SocialService::getAuthorizedUrl(Social::FACEBOOK));
        }
    }

    public function getGoogle()
    {
        $input = Input::all();
        if (isset($input['code'])) {
            SocialService::connectSocial(Social::GOOGLE, $input['code']);
            $social = SocialService::getSocialUser(Social::GOOGLE);
            return SocialService::authenticate(Social::GOOGLE, $social);
        } else {
            return Redirect::to(SocialService::getAuthorizedUrl(Social::GOOGLE));
        }
    }

    public function getGithub()
    {
        $input = Input::all();
        if (isset($input['code'])) {
            SocialService::connectSocial(Social::GITHUB, $input['code']);
            $social = SocialService::getSocialUser(Social::GITHUB);
            return SocialService::authenticate(Social::GITHUB, $social);
        } else {
            return Redirect::to(SocialService::getAuthorizedUrl(Social::GITHUB));
        }
    }
}
