# hot-cover

1, Create app/validators/CustomValidate.php <br />
```
<?php

class CustomValidate extends Illuminate\Validation\Validator
{

public function validateYoutubeUrl($attribute, $value, $parameters)
{
echo "this is the: " . $value;
}

}
```
2, run php artisan optimize or composer dumpautoload <br />

3, Somewhere register your custom validator. Perhaps add app/validators.php into start/global.php <br />
```
Validator::resolver(function($translator, $data, $rules, $message){
return new CustomValidate($translator, $data, $rules, $message);
});
```
4, Validate in model: <br />

`$rules = ['content'=>'required|youtube_url'];`

5, In model: `public static $messages = array('youtube_url' => 'hello');` <br />
6. In controller: `$validation = Validator::make($input, Post::$rules, Post::$messages);`
