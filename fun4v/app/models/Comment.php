<?php

class Comment extends Eloquent {


    protected $guarded = array('id');
    protected $fillable = array('user_id', 'post_id', 'content');

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function post()
    {
        return $this->belongsTo('Post');
    }

    public static $rules = array(
        'content'=>'required',
    );
}
