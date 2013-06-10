<!doctype html>
<html lang="en">
<head>
	<title>lucky_pixeldot's blog</title>
  	<!-- meta -->
	
    <meta http-equiv = "Content-Type" content = "text/html; charset = UTF-8" />
    <meta name = "keywords" content = "UI,设计,lucky,pixeldot,ps,AI">
    <meta name = "description" content = "一个设计师的博客。">
    <meta name="author" content="lucky_pixeldot" />
  
    <!-- link -->
    <link rel="stylesheet" href="../css/lucky.css">
	<link rel="stylesheet" href="../css/component/YUI_reset.css">
	
</head>
<body>

	<section id="wrap">
		<header>
			<div id="header_top">
				<img src="../img/hero.gif" alt="logo" id="hero">
				<p class="hero_name">lucky_pixeldot</p> 
				<div id="slogan">
					<p class="hero_say">用研有女初长成</p>
				</div>	
				<div id="social">
					<ul class="clearfix">
						<li>
							<a href=""><img src="../img/twitter.png"></a>
							<span>Twitter</span>
						</li>
						<li>
							<a href=""><img src="../img/facebook.png"></a>
							<span>Facebook</span>
						</li>
						<li>
							<a href=""><img src="../img/dribble.png" alt=""></a>
							<span>Dribbble</span>
						</li>
					</ul>
				</div>
			</div> 		
		</header>
		<section id="welcome">
			<div id="welcome_text">
				<span>&#8222;</span>
				<p>Welcome</p>
			</div>
			<div class="welcome_article">
				<?php if($nearst_list[0]['img']!= NULL): ?>
					<div class="article_img"><img src="<?php echo $nearst_list[0]['img']?>" style="width:600px;height:308px"></div>
				<?php endif;?>
				<div class="article_content">
					<div class="article_txt">
						<?php if($nearst_list[0] != NULL): ?>
							<h1> <?php echo $nearst_list[0]['title'] ?></h1>
							<p> <?php echo $nearst_list[0]['describe'] ?> </p>
						<?php else :?>
							<?php echo '你还没有写文章哦，快去后台写一篇呗！';?>
						<?php endif;?>
					</div>
					<p class="clearfix read_all"><a href="">阅读全文</a></p>	
					<div class="article_bg"></div>
				</div>
			</div>			
		</section>
		<section id="main" class="clearfix">
			<div id="submain">
				<aside id="achieve">
					<ul class="achieve_nav clearfix">
						<li ><a href="">设计篇(0)</a></li>
						<li class="achieve_nav_active"><a href="">个人篇(1)</a></li>
						<li><a href="">读书上路(0)</a></li>
					</ul>
					<a href="" class="list_taggle"></a>
					<ul class="achieve_item achieve_tag clearfix">
						<li class="achieve_item_tag">标签</li>
						<li class="tag_big"><a href="">PSD</a></li>
						<li class="tag_small"><a href="">UI</a></li>
						<li class="tag_big"><a href="">网页设计</a></li>
						<li class="tag_big"><a href="">用户体验</a></li>
						<li class="tag_small"><a href="">好文</a></li>
						<li class="tag_small"><a href="">界面设计</a></li>
					</ul>
					<ul class="achieve_item achieve_time clearfix">
						<li class="achieve_item_tag">存档时间</li>
						<li class="time"><a href="">2013 年6月</a></li>
						<li class="time"><a href="">2013 年5月</a></li>
						<li class="time"><a href="">2013 年4月</a></li>
						<li class="time"><a href="">2013 年3月</a></li>
					</ul>
					<ul class="achieve_item achieve_focus clearfix">
						<li class="achieve_item_tag">我的关注</li>
						<li><a href="">
							<img src="../img/hero.gif">
						</a></li>
						
					</ul>
				</aside>
				<section id="achieve_detail">
					<article>
						<header class="article_header">
							<h2><?php echo $nearst_list[0]['title'] ?></h2>
							<p><?echo $nearst_list[0]['time']?> | 阅读: <?php echo $nearst_list[0]['num']?></p>
						</header>
						<section class="article_body">
							<?php echo $nearst_list[0]['body']?>
						</section>
						
					</article>
					<section id="list">
						<div id="article_list"> 
						</div>
						
					</section>
				</section>
			</div>
		</section>
		<footer>
			<section id="more">
				<div id="more_wrap">
					<img class="more_dot" src="../img/more_dot.png">
					<a href=""><img class="more_down"  src="../img/more_down.png"></a>
				</div>	
			</section>
			<div id="footer_bottom" class="clearfix">
				<div id="friendlink"> 
					<h4>友情链接</h4>
					<ul class="clearfix">
						<li><a href="">QQ网站导航</a></li>
						<li><a href="">百度联盟UEO</a></li>
						<li><a href="">腾讯CDC</a></li>
					</ul>
					<ul>
						<li><a href="">新浪微博设计</a></li>
						<li><a href="">新浪微博</a></li>
						<li><a href="">搜狐微博</a></li>
					</ul>
				</div>
				<div id="myteam">
					<h4>我的团队</h4>
					<ul class="clearfix">
						<li><a href="">www.dreamfly.org</a></li>
					</ul>
				</div>
				<div id="footer_logo">
					<img src="../img/logo.png" alt="logo">
					<p>designed by lucky_pixeldot</p>
				</div>
				<div id="footer_email">
					<img src="../img/email.png" alt="email">
				</div>

				<div id="thx">
					<p>Copyright &#169; 2013 -自2013开始服务</p>
					<p>特别鸣谢<a href="">zzz</a>、<a href="">xxx</a></p>
				</div>
			</div>
		</footer>
	</section>
	<script src="../js/components/jquery.js"></script>
	<script src="../js/lucky.js"></script>
</body>
</html>