<?php

use Facebook\FacebookRedirectLoginHelper;

class LaravelFacebookRedirectLoginHelper extends FacebookRedirectLoginHelper
{
    public function __construct($redirectUrl, $appId = null, $appSecret = null)
    {
        parent::__construct($redirectUrl, $appId, $appSecret);
    }

    protected function storeState($state)
    {
        Session::put('facebook.state', $state);
    }

    protected function loadState()
    {
        return $this->state = Session::get('facebook.state');
    }
} 