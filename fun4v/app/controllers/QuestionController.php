<?php

class QuestionController extends BaseController {
  protected $layout = "layout";

   public function __construct() {
     $this->beforeFilter('csrf', array('on'=>'post'));
     // $this->beforeFilter('auth', array('only'=>array('getDashboard')));
   }

  public function index()
  {
    $questions = Question::paginate(2);
    return View::make('questions.index', compact('questions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return View::make('questions.create');
  }
}
