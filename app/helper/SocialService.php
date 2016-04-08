<?php

use Facebook\FacebookSession;
use Facebook\FacebookRequest;

class SocialService
{

    public static $sessionKey = [
        Social::FACEBOOK => 'fbAccessToken',
        Social::GOOGLE => 'googleAccessToken',
        Social::GITHUB => 'githubAccessToken',
    ];

    public static function getFields()
    {
        return [
            Social::FACEBOOK => trans('socials.facebook'),
            Social::GOOGLE => trans('socials.google'),
            Social::GITHUB => trans('socials.github'),
        ];
    }

    public static function setSessionAccessToken($type, $token)
    {
        Session::put(self::$sessionKey[$type], $token);
    }

    public static function getSessionAccessToken($type)
    {
        return Session::get(self::$sessionKey[$type]);
    }

    public static function googleClient($urlCallback = '')
    {
        $urlCallback = empty($urlCallback) ? action('SocialsController@getGoogle') : $urlCallback;
        $client = new Google_Client();
        $client->setClientId(Config::get('google.client_id'));
        $client->setClientSecret(Config::get('google.client_secret'));
        $client->setRedirectUri($urlCallback);
        $client->addScope(Config::get('google.scope'));
        return $client;
    }

    public static function getGoogleUserFromToken($token)
    {
        $client = SocialService::googleClient();
        $client->setAccessToken($token);
        $service = new Google_Service_Oauth2($client);
        $userinfo = $service->userinfo->get();
        return [$userinfo->id, $userinfo->email, $userinfo->name, $userinfo->link];
    }

    public static function facebookSession($token = null, $urlCallback = '')
    {
        $urlCallback = empty($urlCallback) ? action('SocialsController@getFacebook') : $urlCallback;
        FacebookSession::setDefaultApplication(Config::get('facebook.appId'), Config::get('facebook.secret'));
        $session = null;
        $helper = new LaravelFacebookRedirectLoginHelper($urlCallback);

        try {
            if ($token) {
                $session = new FacebookSession($token);
                $session->validate();
            } else {
                $session = $helper->getSessionFromRedirect();
            }
        } catch (Exception $ex) {
            return [null, null];
        }
        return [$session, $helper];
    }

    public static function getFacebookUserFromToken($token)
    {
        FacebookSession::setDefaultApplication(Config::get('facebook.appId'), Config::get('facebook.secret'));
        $session = new FacebookSession($token);
        try {
            $session->validate();
        } catch (\Exception $ex) {
            return [null, null, null, null];
        }
        $request = new FacebookRequest($session, 'GET', '/me?fields=id,email,name,link,picture');
        $response = $request->execute();
        $graphObject = $response->getGraphObject();

        $uid = $graphObject->getProperty('id');
        $email = $graphObject->getProperty('email');
        $name = $graphObject->getProperty('name');
        $link = $graphObject->getProperty('link');
        $avatar = $graphObject->getProperty('picture')->getProperty('url');
        return [$uid, $email, $name, $link, $avatar];
    }

    public static function getSocialUser($type)
    {
        $accessToken = SocialService::getSessionAccessToken($type);
        if ($accessToken) {
            switch ($type) {
                case Social::FACEBOOK:
                    return SocialService::getFacebookUserFromToken($accessToken);
                    break;
                case Social::GOOGLE:
                    return SocialService::getGoogleUserFromToken($accessToken);
                    break;
                case Social::GITHUB:
                    return SocialService::getGithubUserFromToken($accessToken);
                    break;
            }
        }
        return [null, null, null, null];
    }

    public static function logoutSocial()
    {
        //Logout Facebook
        $fbAccessToken = Session::get(SocialService::$sessionKey[Social::FACEBOOK]);
        if ($fbAccessToken) {
            Session::forget(SocialService::$sessionKey[Social::FACEBOOK]);
            list($session, $helper) = SocialService::facebookSession($fbAccessToken);
            if ($session) {
                return Redirect::to($helper->getLogoutUrl($session, action('UsersController@getLogout')));
            }
        }

        //Logout and Revoke Google
        $googleAccessToken = Session::get(SocialService::$sessionKey[Social::GOOGLE]);
        if ($googleAccessToken) {
            Session::forget(SocialService::$sessionKey[Social::GOOGLE]);
            $client = SocialService::googleClient();
            $client->setAccessToken($googleAccessToken);
            $client->revokeToken();
        }

        //Logout Github
        $githubAccessToken = Session::get(SocialService::$sessionKey[Social::GITHUB]);
        if ($githubAccessToken) {
            Session::forget(SocialService::$sessionKey[Social::GITHUB]);
        }
    }

    public static function authenticate($type, $social)
    {
        list($uid, $email, $name) = $social;
        if (empty($email)) {
            die("fuck");
        }
        if ($userId = Social::authenticate($type, $uid)) {
            return Redirect::action('PostController@index');
        }
        if (User::where('email', $email)->count() > 0) {
            return Redirect::action('SocialsController@getConfirm', ['type' => $type]);
        }
        return Redirect::action('SocialsController@getConnect', ['type' => $type]);
    }

    public static function githubClient($urlCallback = '')
    {
        $urlCallback = empty($urlCallback) ? action('SocialsController@getGithub') : $urlCallback;
        $client = new GithubApiHelper(Config::get('github'));
        $client->setRedirectUri($urlCallback);
        return $client;
    }

    public static function getGithubUserFromToken($token)
    {
        $github = SocialService::githubClient();
        $userinfo = $github->getUserDetails($token);
        return [$userinfo->id, $userinfo->email, $userinfo->name, $userinfo->html_url];
    }

    public static function authorizedSocial($user, $type)
    {
        $socials = $user->socials()->where('type', $type);
        if ($socials->count() > 0) {
            return $socials->first();
        }
        return false;
    }

    public static function getAuthorizedUrl($type, $urlCallback = '')
    {
        if ($type == Social::FACEBOOK) {
            list($session, $helper) = SocialService::facebookSession(null, $urlCallback);
            return $helper->getLoginUrl(Config::get('facebook.scope'));
        }
        if ($type == Social::GOOGLE) {
            $client = SocialService::googleClient($urlCallback);
            return $client->createAuthUrl();
        }
        if ($type == Social::GITHUB) {
            $github = SocialService::githubClient($urlCallback);
            return $github->getLoginUrl(Config::get('github.scope'));
        }
        return '';
    }

    public static function connectSocial($type, $code = '', $callbackUrl = '')
    {
        if ($type == Social::FACEBOOK) {
            list($session, $helper) = SocialService::facebookSession(null, $callbackUrl);
            if ($session) {
                $accessToken = $session->getAccessToken();
                $longLivedAccessToken = $accessToken->extend();
                SocialService::setSessionAccessToken(Social::FACEBOOK, $longLivedAccessToken);
                return true;
            }
        }
        if ($type == Social::GOOGLE) {
            $client = SocialService::googleClient($callbackUrl);
            $client->authenticate($code);
            SocialService::setSessionAccessToken(Social::GOOGLE, $client->getAccessToken());
            return true;
        }
        if ($type == Social::GITHUB) {
            $github = SocialService::githubClient($callbackUrl);
            $github->authenticate($code);
            $accessToken = $github->getAccessToken();
            SocialService::setSessionAccessToken(Social::GITHUB, $accessToken);
        }
        return false;
    }
} 
