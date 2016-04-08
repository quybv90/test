<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
class User extends Eloquent implements UserInterface, RemindableInterface {
  protected $guarded = array('id');
  protected $fillable = array('name', 'email', 'password', 'avatar_url', 'status', 'type');

  use UserTrait, RemindableTrait;

  public static $rules = array(
      'name' => 'required|min:5',
      'email'=>'required|email|unique:users',
      'password'=>'required|alpha_num|between:6,12|confirmed',
      'password_confirmation'=>'required|alpha_num|between:6,12'
  );
  public static $update_rules = array(
      'name' => 'required|min:5',
      'email'=>'required|email',
      'avatar_url'=>'image|mimes:jpeg,jpg,png,bmp,gif,svg',
      'password'=>'required|alpha_num|between:6,12|confirmed',
      'password_confirmation'=>'required|alpha_num|between:6,12'
  );

  public static $admin_update_rules = array(
      'name' => 'required|min:5',
      'email'=>'required|email',
      'avatar_url'=>'image|mimes:jpeg,jpg,png,bmp,gif,svg',
  );

  public static function authRules($field)
  {
      $validations = [
          'username' => 'required|min:3|max:50',
          'email' => 'required|email|max:50',
      ];
      return [
          $field => $validations[$field],
          'password' => 'required|max:50',
      ];
  }

  public static function validate($input, $field)
  {
      $user = [
          $field => $input[$field],
          'password' => $input['password'],
      ];
      return Auth::validate($user);
  }

  protected $hidden = array('password', 'remember_token');

  public function posts()
  {
      return $this->hasMany('Post', 'user_id');
  }

  public function comments()
  {
      return $this->hasMany('Comment', 'user_id');
  }

  public function questions()
  {
      return $this->hasMany('Question', 'user_id');
  }

  public function answers()
  {
      return $this->hasMany('Answer', 'user_id');
  }

  public function likes()
  {
      return $this->hasMany('Like', 'user_id');
  }

  public function sendMessages()
  {
      return $this->hasMany('Message', 'from_id');
  }

  public function receiveMessages()
  {
      return $this->hasMany('Message', 'to_id');
  }

  public function unreadMessages()
  {
    return $this->receiveMessages()->where('stage', '=', 'unread');
  }
  public function countLiked()
  {
      return $this->likes()->where('like_value', '=', '1');
  }

  public function countDisliked()
  {
      return $this->likes()->where('like_value', '=', '-1');
  }

  public function getRememberToken()
  {
      return $this->remember_token;
  }

  public function setRememberToken($value)
  {
      $this->remember_token = $value;
  }

  public function getRememberTokenName()
  {
      return 'remember_token';
  }
  public function approvedPosts()
  {
      return $this->posts()->where('status', '=', 'Approve');
  }
  public function unApprovedPosts()
  {
      return $this->posts()->whereNotIn('status', ['Approve']);
  }
  public static function rankedUsers($number)
  {
      return DB::table('users')
                        ->join('posts', 'users.id', '=', 'posts.user_id')
                        ->join('likes', 'posts.id', '=', 'likes.post_id')
                        ->select('users.id', 'users.name', 'avatar_url', DB::raw('sum(likes.like_value) AS total_likes'))
                        ->orderBy('total_likes', 'desc')
                        ->groupBy('posts.user_id')
                        ->take($number);
  }

  public static function rankedUsersByEvent($start_date, $end_date)
  {
      return DB::table('users')
        ->join('posts', 'users.id', '=', 'posts.user_id')
        ->join('likes', 'posts.id', '=', 'likes.post_id')
        ->where('posts.created_at', '>=', $start_date)
        ->where('posts.created_at', '<', $end_date)
        ->select('users.id', 'users.name', 'avatar_url', DB::raw('sum(likes.like_value) AS total_likes'))
        ->orderBy('total_likes', 'desc')
        ->groupBy('posts.user_id');
  }
}
