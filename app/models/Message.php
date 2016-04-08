<?php
class Message extends Eloquent {
  protected $guarded = array('id');
  protected $fillable = array('from_id', 'content', 'title', 'slug', 'stage', 'to_id');

  public static $rules = array(
      'title' => 'required|min:5'
  );

  public function from_user()
  {
      return $this->hasOne('User', 'from_id');
  }

  public function to_user()
  {
      return $this->belongsTo('User', 'to_id');
  }
  public function markAsReaded()
  {
    $this->stage = 'readed';
    $this->save();
  }
}
