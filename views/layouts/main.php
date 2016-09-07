<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$this->params['title'];?></title>
    <meta name="title" content="<?=$this->params['title'];?>" />
    <!--<meta name="description" content="<?=$this->params['title'];?>" />-->

    <meta property="vk:title" content="<?=$this->params['title'];?>" />
    <meta property="og:title" content="<?=$this->params['title'];?>" />
    <meta property="vk:description" content="<?=$this->params['title'];?>"/>
    <meta property="og:description" content="<?=$this->params['title'];?>"/>
    <meta property="vk:image" content="<?=$this->params['image'];?>"/>
    <meta property="og:image" content="<?=$this->params['image'];?>"/>
    <meta property="vk:url" content="<?=$this->params['url'];?>"/>
    <meta property="og:url" content="<?=$this->params['url'];?>"/>
    
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
	<link href="/css/sait.css?v=1.0" rel="stylesheet">
	<link href="/css/slider.css" rel="stylesheet">
	<!--<link href="css/responsive.css" rel="stylesheet">-->
        <script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/jssor.slider.min.js"></script>
    <script type="text/javascript" src="/js/slider.js"></script>
<!--    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75328609-1', 'auto');
  ga('send', 'pageview');

</script>

</head><!--/head-->
<?php
$menu=$this->params['menu'];
?>
<body>
	<header id="header"class=""><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
                                                            <li class="phone_detail">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-phone"></i>(093) 18-96-333, &nbsp;&nbsp;(096) 66-25-670&nbsp;&nbsp;&nbsp;   </li>
							    <li class="phone_detail"><i class="fa fa-envelope"></i> i@kochevnik.com.ua</li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a  target="_blank"href="https://vk.com/kochevnik_shop"><i class="fa fa-vk"></i></a></li>
								<li><a  target="_blank"href="https://www.instagram.com/kochevnik.com.ua/"><i class="fa fa-instagram"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
					             <a href="/">
                                                        <img class="main_logo"  src="/images/logo-koch1.png" alt="" />
                                                    </a>	
					</div>
					<div class="col-sm-10">
                                            	<div class="navbar-header">
                                                        <button style="margin-top:-100px;"type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapsem">
                                                            <span class="sr-only">Toggle navigation</span>
                                                            <span class="icon-bar"></span>
                                                            <span class="icon-bar"></span>
                                                            <span class="icon-bar"></span>
                                                        </button>
						</div>
						<div class="mainmenu pull-right">
                                                        <ul class="nav navbar-nav collapse navbar-collapsem mobmenu">
                                                            <li><a href="/" >Главная</a></li>
                                                            <li><a href="/ride" >Велотуризм</a></li>
                                                            <li><a href="/walk" >Туризм</a></li>
                                                            <li><a href="/clothes" >Одежда</a></li>
                                                            <li><a href="/climbing" >Альпинизм</a></li>
                                                            <li><a href="/cart" ><i class="fa fa-shopping-cart"></i>Корзина</a></li>
                                                            <li><a href="/contact" ><i class="fa fa-crosshairs"></i>Контакты</a></li>
                                                        </ul>
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="/" class="active">Главная</a></li>
                                                                <li class="dropdown"><a href="/ride">Велотуризм<i class="fa fa-angle-down"></i></a>
                                                                    <ul role="menu" class="sub-menu">
                                                                        <?php foreach ($menu[1] as $menuy) { ?>
                                                                            <li><a href="/<?= $menuy['engr'] ?>/<?= $menuy['eng'] ?>"><?= $menuy['category'] ?></a></li>
                                                                                
                                                                        <?php }; ?>
                                                                    </ul>
                                                                </li> 
                                                                <li class="dropdown"><a href="/walk">Туризм<i class="fa fa-angle-down"></i></a>
                                                                    <ul role="menu" class="sub-menu">
                                                                        <?php foreach ($menu[2] as $menuy) { ?>
                                                                            <li><a href="/<?= $menuy['engr'] ?>/<?= $menuy['eng'] ?>"><?= $menuy['category'] ?></a></li>
                                                                                
                                                                        <?php }; ?>
                                                                    </ul>
                                                                </li> 
                                                                <li class="dropdown"><a href="/clothes">Одежда<i class="fa fa-angle-down"></i></a>
                                                                    <ul role="menu" class="sub-menu">
                                                                        <?php foreach ($menu[3] as $menuy) { ?>
                                                                            <li><a href="/<?= $menuy['engr'] ?>/<?= $menuy['eng'] ?>"><?= $menuy['category'] ?></a></li>
                                                                                
                                                                        <?php }; ?>
                                                                    </ul>
                                                                </li> 
                                                                <li class="dropdown"><a href="/climbing">Альпинизм<i class="fa fa-angle-down"></i></a>
                                                                    <ul role="menu" class="sub-menu">
                                                                        <?php foreach ($menu[4] as $menuy) { ?>
                                                                            <li><a href="/<?= $menuy['engr'] ?>/<?= $menuy['eng'] ?>"><?= $menuy['category'] ?></a></li>
                                                                                
                                                                        <?php }; ?>
                                                                    </ul>
                                                                </li> 
                          
                                                                <li><a href="/cart"><i class="fa fa-shopping-cart"></i> Корзина &nbsp;<span id="countOrderUser" style="color:red"></span></a> </li>
								<li><a href="/contact"><i class="fa fa-crosshairs"></i> Контакты</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
	
	</header><!--/header-->
              <?= $content ?>
                 <!-- /#content -->

     <footer id="footer" class="header-middle"><!--Footer-->
         <div id="footer" >
             <div class="container">
                 <div class="row">
                     <div class="col-sm-2">
                         <div class="single-widget">
                             <h2>Велотуризм</h2>
                             <ul class="nav nav-pills nav-stacked">
                                 <?php foreach ($menu[1] as $key => $menuy) { ?>
                                     <li><a href="/ride/<?= $menuy['eng'] ?>"><?= $menuy['category'] ?></a></li>
                                     <?php if($key==4) break; ?>
                                 <?php }; ?>
                             </ul>
                         </div>
                     </div>
                     <div class="col-sm-2">
                         <div class="single-widget">
                             <h2>Туризм</h2>
                             <ul class="nav nav-pills nav-stacked">
                                 <?php foreach ($menu[2] as $key => $menuy) { ?>
                                     <li><a href="/walk/<?= $menuy['eng'] ?>"><?= $menuy['category'] ?></a></li>
                                     <?php if($key==4) break; ?>
                                 <?php }; ?>
                             </ul>
                         </div>
                     </div>
                     <div class="col-sm-2">
                         <div class="single-widget">
                             <h2>Одежда</h2>
                             <ul class="nav nav-pills nav-stacked">
                                <?php foreach ($menu[3] as $key => $menuy) { ?>
                                     <li><a href="/clothes/<?= $menuy['eng'] ?>"><?= $menuy['category'] ?></a></li>
                                     <?php if($key==4) break; ?>
                                 <?php }; ?>
                             </ul>
                         </div>
                     </div>
                     <div class="col-sm-2">
                         <div class="single-widget">
                             <h2>Альпинизм</h2>
                             <ul class="nav nav-pills nav-stacked">
                                 <?php foreach ($menu[4] as $key => $menuy) { ?>
                                     <li><a href="/climbing/<?= $menuy['eng'] ?>"><?= $menuy['category'] ?></a></li>
                                     <?php if($key==4) break; ?>
                                 <?php }; ?>
                             </ul>
                         </div>
                     </div>
                     <div class="col-sm-3 col-sm-offset-1">
                         <div class="single-widget">
                             <h2>Где нас найти</h2>
                             <p>г.Винница, Проспект Коцюбинского,70 (возле Петроцентра)</p>
                             <hr>
                             <h2>Котакты</h2>
                             <p>
                             <ul class="nav nav-pills nav-stacked">
                                 <li style="color: #fff;"><i class="fa fa-phone"></i>&nbsp;(093) 18-96-333</li>
                                 <li style="color: #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(096) 66-25-670</li>
                                 <li style="color: #fff;"><i class="fa fa-envelope"></i> i@kochevnik.com.ua</li>
                             </ul>
                           </p>

                         </div>
                     </div>

                 </div>
             </div>
         </div>
         <!-- /#footer -->

         <div id="copyright">
             <div class="container">
                 <div class="col-md-4">
                 </div>
                 <div class="col-md-8">
                     <p class="pull-left">© 2016 Кочевник - экиперовочный центр</p>
                 </div>
             </div>
         </div>
     </footer><!--/Footer-->

    <script src="/js/jquery.js"></script>
    <script src="/js/jquery.cookie.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/bootstrap-select.min.js"></script>
	<!--<script src="js/jquery.scrollUp.min.js"></script>-->
	<!--<script src="js/price-range.js"></script>-->
    <!--<script src="js/jquery.prettyPhoto.js"></script>-->
    <script src="/js/sitescript.js"></script>
</body>
</html>