<?php

class Answer extends Eloquent {
    protected $guarded = array('id');
    protected $fillable = array('content');

    public function answer_rates()
    {
        return $this->hasMany('AnswerRate', 'answer_id');
    }

    public function question()
    {
        return $this->belongsTo('Question');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public static $rules = array(
        'content'=>'required|',
    );
}
