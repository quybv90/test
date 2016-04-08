<?php

class LeechPhoto extends Eloquent {
    protected $guarded = array('id');
    protected $fillable = array('title', 'content', 'description', 'user_id');

    public function user()
    {
      return $this->belongsTo('User');
    }

    public static $rules = array();
}
