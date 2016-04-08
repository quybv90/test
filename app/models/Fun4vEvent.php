<?php
class Fun4vEvent extends Eloquent {
	protected $table = 'fun4v_events';
    protected $guarded = array('id');
    protected $fillable = array('title', 'content', 'user_id', 'status', 'started_date', 'end_date');

    public function user()
    {
        return $this->belongsTo('User');
    }

    public static $rules = array(
        'title' => 'required|min:1',
        'content'=>'required|min:30',
        'started_date'=>'required|date_format:"Y/m/d"',
        'end_date'=>'required|date_format:"Y/m/d"',
    );

    public static function currentEvent()
    {
        return Fun4vEvent::where('status', '=', '1')->orderBy('id', 'desc')->get();
    }
}
