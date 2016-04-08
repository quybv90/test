<?php
use Symfony\Component\DomCrawler\Crawler;
class PostController extends BaseController {
   public function __construct() {
     $this->beforeFilter('csrf', array('on'=>'post'));
     $this->beforeFilter('auth', array('only'=>array('create', 'edit', 'store')));
     $this->beforeFilter('correctUser:Post',array('only'=>array('edit', 'update', 'destroy')));
     $this->beforeFilter('checkAdmin', array('only'=>array('edit', 'update')));
     $this->current_user = Auth::user();
   }
    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'HomeController@showWelcome');
    |
    */

    // public function showWelcome()
    // {
    //     return View::make('hello');
    // }
  public function index()
  {
    // dd(User::rankedUsersByEvent('2015-05-01', '2015-07-10'));
    $active_event = Fun4vEvent::currentEvent();
    $type = Input::get('type');
    if($type == "photo") {
        $posts = Post::orderBy(DB::raw('RAND()'))->where('category', 'photo')->where('status', 'Approve')->Paginate(10);
    } elseif($type == "video") {
        $posts = Post::orderBy(DB::raw('RAND()'))->where('category', 'video')->where('status', 'Approve')->Paginate(10);
    } else {
        $posts = Post::where('status', 'Approve')->orderBy('updated_at', 'desc')->Paginate(10);
    }
    //$posts = DB::table('posts')->get();
    View::share('current_user', $this->current_user);
    $ranked_users = User::rankedUsers(5)->get();
    $hot_images = Post::hotImages("");
    $hot_videos = Post::hotVideos("");
    return View::make('posts.index', compact('posts', 'type', 'hot_images', 'hot_videos', 'ranked_users', 'active_event'));
  }

  public function top()
  {
    $active_event = Fun4vEvent::currentEvent();
    $type = Input::get('type');
    $posts = Post::topPosts()->Paginate(10);
    View::share('current_user', $this->current_user);
    $ranked_users = User::rankedUsers(5)->get();
    $hot_images = Post::hotImages("");
    $hot_videos = Post::hotVideos("");
    return View::make('posts.top', compact('posts', 'type', 'hot_images', 'hot_videos', 'ranked_users', 'active_event'));
  }

  public function vote()
  {
    $active_event = Fun4vEvent::currentEvent();
    $type = Input::get('type');
    $posts = Post::where('status', 'Approve')->orderBy('updated_at', 'desc')->Paginate(10);
    View::share('current_user', $this->current_user);
    $ranked_users = User::rankedUsers(5)->get();
    $hot_images = Post::hotImages("");
    $hot_videos = Post::hotVideos("");
    return View::make('posts.top', compact('posts', 'type', 'hot_images', 'hot_videos', 'ranked_users', 'active_event'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    if (Post::createdToday(Auth::user()->id)->count() > 4 && Auth::user()->type != "Admin"){
      return Redirect::route('posts.index')
      ->with("message", Lang::get("common.limited_posts"));
    }
    $category_session =  Session::get('category');
    $category = isset($category_session) ? (string)$category_session : "false";
    return View::make('posts.create', compact('category'));
  }
  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $input = Input::all();
    if($input['category'] == 'video') {
        $validation = Validator::make($input, Post::$rules_video, Post::$messages);
    } else {
        $validation = Validator::make($input, Post::$rules);
    }
    $post =  new Post($input);
    if (Input::hasFile('content')) {
        $url_images = '';
        $files = Input::file('content');
        foreach($files as $file) {
          $img_folder = '/img/'.Carbon\Carbon::now()->toDateString().'/';
          $destinationPath = public_path().$img_folder;
          $filename        = Str::slug(str_random(6) . '_' . explode(".", $_FILES['content']['name'][0])[0]) . '.' . explode("/", $_FILES['content']['type'][0])[1];
          $uploadSuccess   = $file->move($destinationPath, $filename);
          if ($url_images == '') {
            $url_images =  $img_folder . $filename;
          } else {
            $url_images =  $url_images."\n" .$img_folder . $filename;
          }
        }
        $post->content = $url_images;
    }
    $post->is_hot = Input::get("is_hot");
    if (Auth::user()->type == "Admin"){
      $post->status = 'Approve';
    }
    if ($validation->passes())
    {
      $post->save();
      $count_view = [];
      $count_view["post_id"] = $post["id"];
      $count_view["total_view"] = Auth::user()->type == "Admin" ? rand(500, 2000) : rand(50, 150);
      CountView::create($count_view);
      $message = Auth::user()->type == "Admin" ? Lang::get("posts.approved") : Lang::get("posts.new_created");
      return Redirect::route('posts.index')->with('message', $message);
    }
    return Redirect::route('posts.create')
        ->withInput()
        ->with('category', $input['category'])
        ->withErrors($validation)
        ->with('message', 'There were validation errors.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($slug, $id)
  {
    $previous_id = Post::where('status', ["Approve"])->where('id', '<', $id)->max('id');
    $next_id = Post::where('status', ["Approve"])->where('id', '>', $id)->min('id');
    $previous_post = Post::find($previous_id);
    $next_post = Post::find($next_id);

    $post = Post::find($id);
    $per_page = Config::get('constants.SHOW_POST_PER_PAGE');
    $avatar = $current_name = "";
    if(isset($this->current_user)) {
        $avatar = asset($this->current_user->avatar_url);
        $current_name = $this->current_user->name;
    }
    $posts = Post::all()->take(3);
    $total_record = count(explode("\n", $post->content));
    $total_groups = $total_record;
    if (Request::ajax()) {
      if ((int)Input::get('group_no') < $total_record) {
        $data = ViewHelper::displayOnePhotobyIndex($post->content, (int)Input::get('group_no'));
        return json_encode($data);
      }
    }else{
      if ($post->status == "New"){
        if (!Auth::check() || (Auth::user()->type != "Admin" && !Helper::correctUser(Auth::user()->id, $post->user->id))){
          return Redirect::route('posts.index')->with('message', Lang::get("common.not_permission"));
        }
      }
      $hot_images = Post::hotImages($id);
      $hot_videos = Post::hotVideos($id);
      $count_view = CountView::where('post_id', $id)->first();
      $count_view->increment('total_view');
      $comments = $post->comments()->orderBy('id', 'DESC')->get();
      $show_comments = $comments->take($per_page);
      View::share('current_user', $this->current_user);
      $page_title = $post->title;
      $post_image = $post->category == "photo" ? ViewHelper::getOnePhoto($post->content) : ViewHelper::mqThumbVideo($post->content);
      return View::make('posts.show', compact(array('post',
       'posts', 'comments', 'current_user', 'show_comments',
        'per_page', 'avatar', 'current_name','total_groups', 'hot_videos', 'hot_images', 'page_title', 'post_image', 'previous_post', 'next_post')));
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
    {
        $post = Post::find($id);
        if (is_null($post))
        {
            return Redirect::route('posts.index');
        }
        return View::make('posts.edit', compact('post'));
    }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $post = Post::find($id);
    if (Request::ajax()) {
      $post->rate = Input::get('rate');
      $post->update();
      return json_encode("ok");
    }else{
      $input = Input::all();
      $validation = Validator::make($input, Post::$rules);
      if ($validation->passes())
      {
          $post->update($input);
          return Redirect::route('posts.show', $id);
      }
      return Redirect::route('posts.edit', $id)
        ->withInput()
        ->withErrors($validation)
        ->with('message', 'There were validation errors.');
      }
    }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $post = Post::find($id);
    $post->delete();
    return Redirect::route('posts.index')
      ->with("message", " deleted");
  }

  public function leech_photo()
  {
    View::share('current_user', $this->current_user);
    return View::make('posts.leech_photo');
  }

  public function leech_photo_vietyo()
  {
   $url = 'http://vietyo.com/forum/hot-boy-hot-girl/';
    $content = file_get_contents($url);
    $crawler = new Crawler($content);

    $itemList = [];
    $crawler->filter('div.fleft > div.rowsolid')->each(function(Crawler $mainDiv, $i) use(&$itemList) {
      if ($i > 1 && $mainDiv->attr('class') !== 'rowsolid alt') {
        if ($mainDiv->filter('img')->count()) {
          $imgUrl = $mainDiv->filter('img')->attr('src');
          $title  = $mainDiv->filter('h2 > a')->text();
          $title = preg_replace('/\[(.*)\](\s*)/', '', $title);
          $title = preg_replace('/(Vietyo|Viet yo|ViệtYo|ViêtYo)/i', 'Fun4v', $title);
          $title = str_replace('"', '', trim($title));
          $linkUrl = $mainDiv->filter('h2 > a')->attr('href');
          preg_match('/\/(t\d+)\//', $linkUrl, $id);
                    $id = $id[1];         
          //echo "<a href='$linkUrl'>$title</a> &nbsp; &nbsp; <img src='$imgUrl' /><br/>";
          if (Post::where('description', 'vietyo|' . $id)->count() == 0) {
            $detailContent = file_get_contents($linkUrl);
            $detailCrawler = new Crawler($detailContent);
            $detailHtml = implode(PHP_EOL, $detailCrawler->filter('div[id^="post_"] img.bbcode_img:not([alt$=".gif"])')->extract(['src']));
            $post = Post::create([            
              'user_id' => $this->current_user->id,
              'title' => $title,
              'content' => $detailHtml,
              'is_hot' => 1,
              'status' => 'Approve',
              'type' =>  'normal',
              'category' => 'photo',
              'is_new' => 1,
              'description' => 'vietyo|' . $id,
            ]);
            if ($post) {
              $count_view = [];
              $count_view["post_id"] = $post["id"];
              $count_view["total_view"] = rand(500, 2000);
              CountView::create($count_view);
              echo $post["id"] . "<br/>";
            }
          }
        }
      }
    });
  }
  
  public function leech_photo_gioitre()
  {
	$url = 'http://gioitre.net/girl-xinh';
	$content = file_get_contents($url);
	$crawler = new Crawler($content);

	$itemList = [];
	$crawler->filter('div.listLage li')->each(function(Crawler $mainDiv, $i) use(&$itemList) {
		$imgUrl = $mainDiv->filter('img')->attr('src');
		$title  = $mainDiv->filter('p.cat-tit > a')->text();
		$title = str_replace('"', '', trim($title));
		$linkUrl = 'http://gioitre.net' . $mainDiv->filter('p.cat-tit > a')->attr('href');
		preg_match('/\-(\d+)$/', $linkUrl, $id);
		$id = $id[1];		
		if (Post::where('description', 'gioitre|' . $id)->count() == 0) {
			$detailContent = file_get_contents($linkUrl);
			$detailCrawler = new Crawler($detailContent);
			$detailHtml = implode(PHP_EOL, $detailCrawler->filter('div.contentDeatil img:not([src$=".gif"])')->extract(['src']));
			$post = Post::create([						
				'user_id' => $this->current_user->id,
				'title' => $title,
				'content' => $detailHtml,
				'is_hot' => 1,
				'status' => 'Approve',
				'type' =>  'normal',
				'category' => 'photo',
				'is_new' => 1,
				'description' => 'gioitre|' . $id,
			]);
			if ($post) {
				$count_view = [];
				$count_view["post_id"] = $post["id"];
				$count_view["total_view"] = rand(500, 2000);
				CountView::create($count_view);
				echo $post["id"] . "<br/>";
			}
		}
	});
    return 'Done';		
  }
  
  public function leech_photo_wn()
  {
		$url = 'http://www.wn.com.vn/brands/Anh-Girl-xinh.html';
        $content = file_get_contents($url);
        $crawler = new Crawler($content);

        $itemList = [];
        $crawler->filter('ul.ProductList > div')->each(function(Crawler $mainDiv, $i) use(&$itemList) {
            if ($i < 5) {
                $imgUrl = $mainDiv->filter('img')->attr('data-original');
                $title  = $mainDiv->filter('div.article-content h2 a')->text();
                $title = str_replace('"', '', trim($title));
                $linkUrl = $mainDiv->filter('div.article-content h2 a')->attr('href');
                preg_match('/([\w\-]+)\.html$/', $linkUrl, $id);
                $id = $id[1];
                //
				if (Post::where('description', 'wn|' . $id)->count() == 0) {
					$ch =  curl_init($linkUrl);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$detailContent = curl_exec($ch);
					$detailCrawler = new Crawler($detailContent);
					$detailHtml = implode(PHP_EOL, $detailCrawler->filter('div.shortcode-content div.column9 p img:not([src$=".gif"])')->extract(['src']));
					$post = Post::create([						
						'user_id' => $this->current_user->id,
						'title' => $title,
						'content' => $detailHtml,
						'is_hot' => 1,
						'status' => 'Approve',
						'type' =>  'normal',
						'category' => 'photo',
						'is_new' => 1,
						'description' => 'wn|' . $id,
					]);
					if ($post) {
						$count_view = [];
						$count_view["post_id"] = $post["id"];
						$count_view["total_view"] = rand(500, 2000);
						CountView::create($count_view);
						echo $post["id"] . "<br/>";
					}
				}
            }
        });
    return 'Done';		
  }
  
  public function leech_photo_ohdep()
  {
	$url = 'http://ohdep.net';
	$content = file_get_contents($url);
	$crawler = new Crawler($content);

	$itemList = [];
	$crawler->filter('div.masonry_item')->each(function(Crawler $mainDiv, $i) use(&$itemList, $url) {
		$imgUrl = $mainDiv->filter('img')->attr('src');
		$title  = $mainDiv->filter('div.title_img a')->text();
		$title = str_replace('"', '', trim($title));
		$linkUrl = $mainDiv->filter('div.title_img a')->attr('href');
		preg_match('/^\/(\w+)\//', $linkUrl, $id);
		$id = $id[1];
		$linkUrl = $url . $linkUrl;
		//
		if (Post::where('description', 'ohdep|' . $id)->count() == 0) {
			$ch =  curl_init($linkUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$detailContent = curl_exec($ch);
			$detailCrawler = new Crawler($detailContent);
			$detailHtml = implode(PHP_EOL, $detailCrawler->filter('div.post_pcontent img:not([src$=".gif"])')->extract(['src']));
			$post = Post::create([						
				'user_id' => $this->current_user->id,
				'title' => $title,
				'content' => $detailHtml,
				'is_hot' => 1,
				'status' => 'Approve',
				'type' =>  'normal',
				'category' => 'photo',
				'is_new' => 1,
				'description' => 'ohdep|' . $id,
			]);
			if ($post) {
				$count_view = [];
				$count_view["post_id"] = $post["id"];
				$count_view["total_view"] = rand(500, 2000);
				CountView::create($count_view);
				echo $post["id"] . "<br/>";
			}
		}
	});
    return 'Done';		
  }
  
  
}
