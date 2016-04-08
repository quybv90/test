<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Trang chuyên về ảnh gái xinh, clip hot của các người đẹp, hotgirl">
    <meta name="author" content="">

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
    <title>{{ isset($page_title) ? $page_title : "Fun4v - Ảnh gái xinh, clip hot" }}</title>
    <meta property="og:site_name" content="gaixinh.fun4v.com"/>
    <meta property="og:image" content="{{ isset($post_image) ? $post_image : "http://gaixinh.fun4v.com/images/logo-site2.png" }}"/>
    <meta property="og:description" content="Click để ngắm gái và thư giãn mỗi ngày cùng gaixinh.fun4v.com"/>

    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/star-rating.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-markdown.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modern-business.css') }}" rel="stylesheet">
    <link href="{{ asset('css/like_and_dislike.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <!-- <link href="{{ asset('css/1-col-portfolio.css') }}" rel="stylesheet"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/jquery.qrcode-0.11.0.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/star-rating.js') }}"></script>
    @include('partials.like_and_dislike')
    @include('partials.qr_code')
    @include('partials.facebook_init')
    <script src="{{ asset('js/bootstrap-markdown.js') }}"></script>
    <script src="{{ asset('js/jquery.timeago.js') }}"></script>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href='{{ URL::route("index") }}'><span class="glyphicon"><img src="{{ asset('images/logo-site2.png') }}" style="max-width:100px;"></span></a>
                </a>
            </div>
            <!-- Brand and toggle get grouped for better mobile display -->


            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li>
                        {{ link_to_route('posts.index', Lang::get('common.header.video'), array("type=video"), array('class' => '', 'id' => 'typeVideo')) }}
                    </li>
                    <li>
                        {{ link_to_route('posts.index', Lang::get('common.header.girl_photo'), array("type=photo"), array('id' => 'typePhoto')) }}
                    </li>
                    <li>
                        <!-- {{ link_to_route('posts.index', Lang::get('common.header.funny_photo'), array("type=funny_photo"), array('id' => 'typePhoto')) }} -->
                        <a href="http://fun4v.com/" id="">{{Lang::get("common.header.news")}}</a>
                    </li>
                </ul>
		        <ul class="nav pull-right navbar-nav">
            	  @if(!Auth::check())
              		<li>{{ HTML::link('signup', Lang::get("common.sign_up")) }}</li>
              		<li>{{ HTML::link('login', Lang::get("common.log_in")) }}</li>
            	  @else
                    <li>{{ link_to_action('PostController@create', Lang::get("posts.create"), array(), array('class' => 'btn btn-danger')) }}</li>
                    @if(Auth::user()->type == "Admin")
                        <li>{{ HTML::link('/admin', "Admin's Page") }}</li>
                    @endif
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->name}} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <!-- <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i>{{ link_to_route('leech_photos.index', 'My clipboad') }}</a>
                        </li> -->
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i>{{ link_to_route('users.show', Lang::get("common.my_profile"), ['id' => Auth::id()]) }}</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i>{{ link_to_route('users.edit', Lang::get("common.settings"), array(Auth::user()->id)) }}</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            {{ HTML::link('logout', Lang::get("common.logout")) }}<i class="fa fa-fw fa-power-off"></i>
                        </li>
                    </ul>
                </li>
            	  @endif
          	</ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        @if (Session::has('message'))
            <div class="flash bg-danger alert">
                <p>{{ Session::get('message') }}</p>
            </div>
        @endif
    </div>
    <div class="container">
        <div>
            @yield('content')
        </div>
    </div>
        <!-- Footer -->
        <footer>
            <div class="row" id="footer">
              <div class="foot-wrap container">
              <div class="row">
                <div class="col-md-6">
                    <p class="text-letf">Fun4v – Giải trí tổng hợp, ảnh gái xinh, tin tức hot, clip hài&nbsp; ©&nbsp;2015</p>
                </div>
                <div class="col-md-6">
                    <p class="text-right">Copyright @ 2015 by <a href="http://fun4v.com">fun4v.com</a></p>
                </div>
              </div> 
              <div class="row">
                <div class="text-center">
                    <b class="text-info"><a href="{{route('static_page', ['filename' => 'noi-quy'])}}"> Nội quy </a></b>|
                    <b class="text-info"><a href="{{route('static_page', ['filename' => 'dieu-khoan'])}}"> Điều khoản sử dụng </a></b>|
                    <b class="text-info"><a href="{{route('static_page', ['filename' => 'faq'])}}"> Hỏi đáp </a></b>|
                    <b class="text-info"><a href="{{route('static_page', ['filename' => 'lien-he'])}}"> Liên hệ</a></b>
                </div>
              </div>
              </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-63594584-2', 'auto');
        ga('send', 'pageview');

    </script>
</body>

</html>
