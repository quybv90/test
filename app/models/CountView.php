<?php

class CountView extends Eloquent {

    protected $guarded = array('id');
    protected $fillable = array('post_id', 'total_view');
    protected $table = 'count_views';

    public function post()
    {
        return $this->belongsTo('Post');
    }
}
