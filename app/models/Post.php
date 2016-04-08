<?php
class Post extends Eloquent {

    protected $guarded = array('id');
    protected $fillable = array('title', 'content', 'description', 'rate',
        'user_id', 'status', 'type', 'category', 'is_hot');

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function comments()
    {
        return $this->hasMany('Comment', 'post_id');
    }

    public function countview()
    {
        return $this->hasOne('CountView')->first();
    }

    public static $messages = array(
        'youtube_url' => 'Wrong youtube Url !',
    );

    public static $rules_video = array(
        'title' => 'required|min:1',
        'content'=>'required|youtube_url',
        'rate'=>'min:0|max:5',
    );

    public static $rules = array(
        'title' => 'required|min:1',
        'content'=>'required',
        'rate'=>'min:0|max:5',
    );

    public function likes()
    {
        return $this->hasMany('Like', 'post_id');
    }

    public static function createdToday($user_id)
    {
        return Post::whereRaw('user_id = ? and created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)', array($user_id))->get();
    }

    public function total_views()
    {
        return $this->countview()->total_view;
    }

    public function true_likes(){
        return $this->likes()->where('like_value', '=', '1');
    }
    public function disLikes(){
        return $this->likes()->where('like_value', '=', '-1');
    }
    public static function newPosts()
    {
        return Post::where('status', '=', 'New');
    }
    public static function hotImages($id='')
    {
        return Post::where('is_hot', '=', '1')->whereNotIn('id', [$id])->where('category', '=', 'photo')->orderBy(DB::raw('RAND()'))->take(3)->get();
    }
    public static function hotVideos($id)
    {
        return Post::where('is_hot', '=', 1)->whereNotIn('id', [$id])->where('category', '=', 'video')->orderBy(DB::raw('RAND()'))->take(3)->get();
    }
    public static function userHotPosts($user_id)
    {
        return Post::where('is_hot', '=', 1)->where('status', ["Approve"])->where('user_id', [$user_id])->orderBy('id', 'desc')->take(3)->get();
    }

    public static function userAllPosts($user_id)
    {
        return Post::where('user_id', [$user_id])->orderBy('id', 'desc');
    }
    public static function userApprovedPosts($user_id)
    {
        return Post::where('user_id', [$user_id])->where('status', ["Approve"])->orderBy('id', 'desc');
    }
    public function getUrlAttribute() {
        return route('post_show', ['slug' => Str::slug($this->title), 'id' => $this->id]);
    }
    public static function topPosts()
    {
        return Post::join('likes', 'posts.id', '=', 'likes.post_id')
          ->select('posts.id', 'posts.title', 'posts.content', 'posts.description',
           'posts.created_at', 'posts.user_id', 'posts.status', 'posts.type', 'posts.category',
           'posts.is_hot', DB::raw('sum(likes.like_value) AS total_likes'))
          ->where('status', ["Approve"])
          ->groupBy('likes.post_id')
          ->orderBy('likes.created_at', 'desc');
          //->havingRaw('total_likes > 4');
    }
}
