
<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>404 error page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-63594584-2', 'auto');
    ga('send', 'pageview');

</script>
<script async type='text/javascript' src='' id=''></script>

	<div class="wrap">
		<div class="content">
			<div class="404">
				<h1><a href="#"><img src="images/404.png"/></a></h1>
				<span>Oh, Chúng tôi không thể tìm thấy trang này!
				 Quay lại <span>{{ link_to_route('top', Lang::get('common.header.top'), array(), array('class' => '', 'id' => 'top')) }}</span></span>
			</div>
		</div>
	</div>

	<p class="copy_right">&#169; 2015 Template by {{ link_to_route('top', 'fun4v.com', array(), array('class' => '', 'id' => 'top')) }}</p>
</body>
</html>
</style>
<style type="text/css">
.wrap {
  width: 25%;
  margin: 5.2% auto 4% auto;
}
.logo {
  padding: 1em;
  text-align: center;
  padding: 1% 1% 5% 1%;
}
a {
  text-decoration: none;
}
img {
  max-width: 100%;
}
.copy_right {
  font-size: 0.85em;
  line-height: 1.8em;
  padding: 0em 25px 0px 0px;
  font-family: 'open_sansregular';
  text-align: center;
}
</style>