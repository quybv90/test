@extends('layouts.visitor')
@section('content')
    <!-- Header Carousel -->
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner"style="margin-top:-20px">
            <div class="item active">
                <div class="fill" style="background-image:url('http://www.f-covers.com/cover/miranda-kerr-4-facebook-cover-timeline-banner-for-fb.jpg');"></div>
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('http://img.covry.com/covers/cv/beautiful-girl-resting-on-a-bed.jpg');"></div>
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('http://www.hdwallpaperss.com/myadmin/img/HDWALLPAPERSS.COM1346147652_super_beautiful_girl-fcover.jpg');"></div>
                <div class="carousel-caption">
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>
    <!-- Page Content -->
    <div class="container">


        <!-- Portfolio Section -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Framgia Entertaiment</h2>
            </div>
            <div class="col-md-4 col-sm-6">
                <h3><span> Photo - Clip </span></h3>
                <a href="posts">
                    <img class="img-responsive img-portfolio img-hover" src="http://img2.blog.zdn.vn/38338021.jpg" style="width:700px;height:230px;" alt="">
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <h3><span> Tech / Q&A</span></h3>
                <a href="questions">
                    <img class="img-responsive img-portfolio img-hover" src="http://confedpark55plus.ca/wp-content/uploads/2014/08/cache/TechClass-290x175@2x.jpg" style="height:230px;"alt="">
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <h3><span> Numeric Club</span></h3>
                <a href="portfolio-item.html">
                    <img class="img-responsive img-portfolio img-hover" src="http://thumbs.dreamstime.com/x/numeric-baby-blocks-13297387.jpg" style="width:500px;height:230px;"alt="">
                </a>
            </div>
        </div>
        <!-- /.row -->

        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    News
                </h1>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-check"></i> Bootstrap v3.2.0</h4>
                    </div>
                    <div class="panel-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?</p>
                        <a href="#" class="btn btn-default">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-gift"></i> Free &amp; Open Source</h4>
                    </div>
                    <div class="panel-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?</p>
                        <a href="#" class="btn btn-default">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-compass"></i> Easy to Use</h4>
                    </div>
                    <div class="panel-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?</p>
                        <a href="#" class="btn btn-default">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
