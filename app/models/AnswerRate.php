<?php

class AnswerRate extends Eloquent {
    protected $guarded = array('id');
    protected $fillable = array('rate');


    public function answer()
    {
        return $this->belongsTo('Answer');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public static $rules = array(
        'content'=>'required|',
    );
}
