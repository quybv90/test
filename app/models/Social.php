<?php

class Social extends BaseModel
{
    use SoftDeletingTrait;

    const FACEBOOK = 'facebook';
    const GOOGLE = 'google';
    const GITHUB = 'github';

    protected $table = 'socials';

    protected $guarded = ['id'];

    protected $fillable = ['user_id', 'type', 'email', 'uid', 'link'];

    public static $createRules = [
        'user_id' => 'required',
        'type' => 'required',
        'uid' => 'required',
        'email' => 'required|email|max:50|unique:users,email'
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public static function authenticate($type, $uid)
    {
        $social = Social::where('type', $type)->where('uid', $uid)->first();
        if (empty($social)) {
            return false;
        } else {
            Auth::loginUsingId($social->user_id);
            return $social->userId;
        }
    }
} 
