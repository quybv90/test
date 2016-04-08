<?php

class Question extends Eloquent {
    protected $guarded = array('id');
    protected $fillable = array('title', 'content', 'type');


    public function answers()
    {
        return $this->hasMany('Answer', 'question_id');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public static $rules = array(
        'title' => 'required|min:10',
        'content'=>'required|',
    );
}
