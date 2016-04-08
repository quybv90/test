<?php
class StaticController extends BaseController
{	
	public function __construct() {
	  $this->current_user = Auth::user();
	}
	public function show($filename)
	{	
		switch ($filename) {
		 	case 'new-view':
		 		$type = Input::get('type');
				if($type == "photo") {
				    $posts = Post::where('category', 'photo')->where('status', 'Approve')->orderBy('updated_at', 'desc')->Paginate(10);
				} elseif($type == "video") {
				    $posts = Post::where('category', 'video')->where('status', 'Approve')->orderBy('updated_at', 'desc')->Paginate(10);
				} else {
				    $posts = Post::where('status', 'Approve')->orderBy('updated_at', 'desc')->Paginate(10);
				}
				//$posts = DB::table('posts')->get();
				View::share('current_user', $this->current_user);
				$ranked_users = User::rankedUsers(5)->get();
				$hot_images = Post::hotImages("");
				$hot_videos = Post::hotVideos("");
				$active_event = Fun4vEvent::currentEvent();
				return View::make("statics.". $filename, compact('posts', 'type', 'hot_images', 'hot_videos', 'ranked_users', 'active_event'));		 	
		 	case 'bang-xep-hang':
		 		$hot_images = Post::hotImages("");
				$hot_videos = Post::hotVideos("");
				$all_ranked_users = User::rankedUsers(500)->Paginate(20);
				$od = '';
				$current_date = date('Y-m-d', strtotime(' +1 day'));
				if (Input::get('od') == "monthy") {
					$od = 'monthy';
					$target_date = date('Y-m-d', strtotime('first day of this month'));
					$all_ranked_users = User::rankedUsersByEvent($target_date, $current_date)->Paginate(20);
				} elseif (Input::get('od') == "weekly") {
					$od = 'weekly';
					$target_date = date('Y-m-d', strtotime('monday this week'));
					$all_ranked_users = User::rankedUsersByEvent($target_date, $current_date)->Paginate(20);
				}
		 		return View::make("statics.". $filename, compact('hot_images', 'hot_videos', 'all_ranked_users', 'od'));
		 	default:
		 		return View::make("statics.". $filename);
		 }
		
	}
}
?>