<?php
class ViewHelper
{
    public static function convertUrl($url=''){
        $id = '';
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $id = $match[1];
        }
        $embed_url = "http://www.youtube.com/embed/" . $id;
        return $embed_url;
    }

    public static function mqThumbVideo($url=''){
        $id = '';
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $id = $match[1];
        }
        $thumb_url = 'http://img.youtube.com/vi/'.$id.'/default.jpg';
        return $thumb_url;
    }

    public static function displayPhoto($post='') {
        $urls = $post->content;
        $arr_photo =  explode("\n", $urls);
        foreach($arr_photo as $photo) {
            echo '<img title="'.$post->title.'" alt="'.$post->title.'" src=' . $photo . ' /><br/><br />';
        }
    }

    public static function displayPhotobyImgNumber($urls='', $img_num) {
        $arr_photo =  explode("\n", $urls);
        $n = count($arr_photo) > $img_num ? $img_num : count($arr_photo); 
        for ($i=0; $i < $n; $i++) { 
            echo '<img src=' . $arr_photo[$i] . ' style="max-width:90%;" /><br/><br />';
        }
    }

    public static function displayOnePhotobyIndex($urls='', $i){
        $arr_photo =  explode("\n", $urls);
        echo '<img src=' . $arr_photo[$i] . ' style="max-width:90%;" /><br/><br />';
    }

    public static function displayOnePhoto($urls='', $post_title, $post_id) {
        $post_show_url = route('post_show', ['slug' => Str::slug($post_title), 'id' => $post_id]);
        $arr_photo =  explode("\n", $urls);
        echo '<a target="_blank" href="' . $post_show_url . '"><img title="'.$post_title.'" alt="'.$post_title.'" src=' . $arr_photo[0] . ' style="max-width:90%;" /></a><br/><br />';
        if(count($arr_photo) > 1) {
            echo '<div class="col-md-9 text-right">
                <a href="' . $post_show_url . '" id="singlebutton" name="singlebutton" class="btn btn-warning">'.Lang::get("posts.view_all_posts1").' ' . count($arr_photo)  . ' '.Lang::get("posts.view_all_posts2").'</a>
                </div>
                ' ;
        }
    }

    public static function displayJustOnePhoto($urls='', $post_title, $post_id) {
        $post_show_url = route('post_show', ['slug' => Str::slug($post_title), 'id' => $post_id]);
        $arr_photo =  explode("\n", $urls);
        echo '<a target="_blank" href="' . $post_show_url . '"><img src=' . $arr_photo[0] . ' style="max-width:90%;" /></a><br/><br />';
    }

    public static function getOnePhoto($urls='') {
        $arr_photo =  explode("\n", $urls);
        if (str_contains($arr_photo[0], 'http://') || str_contains($arr_photo[0], 'https://')) {
            return $arr_photo[0];
        }
        return Config::get('app.url') . $arr_photo[0];
    }

    public static function time_elapsed_string($ptime) {
        $time = strtotime($ptime->toDateTimeString());
        $etime = time() - $time;

        if ($etime < 1) {
            return '0 seconds';
        }

        $a = array( 12 * 30 * 24 * 60 * 60  =>  Lang::get("common.year"),
            30 * 24 * 60 * 60       =>  Lang::get("common.month"),
            24 * 60 * 60            =>  Lang::get("common.day"),
            60 * 60                 =>  Lang::get("common.hour"),
            60                      =>  Lang::get("common.minute"),
            1                       =>  Lang::get("common.second"),
        );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . $str;
                // return $r . ' ' . $str . ($r > 1 ? 's' : '');
            }
        }
    }
    public static function displaySmallPhoto($urls='') {
        $arr_photo =  explode("\n", $urls);
        foreach($arr_photo as $key=>$photo) {
            echo '<img src=' . $photo . ' style="max-width:20%; heigh:50px" /> ';
            if ((($key +1) % 4) == 0) {echo "<br>";}
        }
    }

    public static function displayJustOneSmallPhoto($urls='', $post_id) {
        $arr_photo =  explode("\n", $urls);
        echo '<a href="posts/' . $post_id . '"><img src=' . $arr_photo[0] . ' style="max-width:50%; heigh:100px" /></a>';
    }

    public static function getFirstImage($urls='') {
        $arr_photo =  explode("\n", $urls);
        echo $arr_photo[0];
    }

    public static function fbShareButton($post) {
        echo '<div class="fb-share-button" data-href="'.$post->url.'" data-layout="button_count"></div>';
    }

    public static function fbLikeButton($post) {
        echo '<div class="fb-like" data-href="'.$post->url.'" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>';
    }

    public static function fbComementCount($post) {
        echo '<span class="fb-comments-count " data-href="'.$post->url.'"></span> Comments';
    }

    public static function fbComementBox($post) {
        echo '<div class="fb-comments" data-href="'.$post->url.'" data-numposts="5" data-colorscheme="light"></div>';
    }

    public static function likeNumber($num) {
        if ($num > 0) {
            echo '('.$num.')';
        }
    }

    public static function from_user_name($message) {
        if ($message->stage == "feedback") {
            echo "Feedback";
        } else {
            $admin_user_ids = User::where('type', '=', 'Admin')->lists('id');
            if (in_array($message->from_id, $admin_user_ids)) {
                echo 'Ban Quản Trị Fun4v.com';
            } else {
                echo User::find($message->from_id)->name;
            }
        }
    }
}
?>
