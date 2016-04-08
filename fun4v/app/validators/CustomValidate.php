<?php

class CustomValidate extends Illuminate\Validation\Validator
{

    public function validateYoutubeUrl($attribute, $value, $parameters)
    {
        $rule = (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $value, $match));
        return $rule;
    }
}
