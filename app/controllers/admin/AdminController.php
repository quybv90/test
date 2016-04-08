<?php
namespace admin;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller;
use \User as User;
class AdminController extends BaseAdminController {
  protected $layout = "layouts.admin";
  public function index()
  {
    $users = User::orderBy('id', 'desc')->paginate(20);
    return View::make('admins/admin.index', compact("users"));
  }
}
