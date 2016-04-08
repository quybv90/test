<?php
namespace admin;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller;
use Input;

class BaseAdminController extends \BaseController {
  protected $layout = "layouts.admin";

   public function __construct() {
     $this->beforeFilter('csrf', array('on'=>'post'));
     $this->beforeFilter('auth');
     $this->beforeFilter('checkAdmin');
   }

   // public function checkAdmin(){
   //   if(Auth::user()->type != "Admin"){
   //     return Redirect::to("/posts")->with('message', 'Your are not Admin!');
   //   }
   // }
}
