<?php 
Validator::resolver(function($translator, $data, $rules, $message){
    return new CustomValidate($translator, $data, $rules, $message);
});
