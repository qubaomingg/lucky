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
				<?php if($welcomelist['img']!= NULL): ?>
					<div class="article_img"><img src="<?php echo $welcomelist['img']?>" style="width:600px;height:308px"></div>
				<?php endif;?>
				<div class="article_content">
					<div class="article_txt">
						<?php if($welcomelist != NULL): ?>
							<h1> <?php echo $welcomelist['title'] ?></h1>
							<p> <?php echo $welcomelist['describe'] ?> </p>
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
							<h2>打造扁平化设计的5大原则</h2>
							<p>2013/05/31|阅读: 0</p>
						</header>
						<section class="article_body">
							<p>Kryptoners：如今设计界最炙手可热的明星大概就是扁平化设计了吧，关于它的讨论至今都没有冷却的迹象。诸多设计师分成了泾渭分明的两个阵营，一边努力把扁平化做到极致，一面对其不屑一顾。</p>
							<p>我是个骑墙派，不支持也不反对，在我看来，优秀的设计的定义就是好用，只要能设计出优秀的产品，我可以采用任何方式，扁平化也是其中之一。但是必须意识到，没有哪种风格是包打天下的，不能强行将一种风格应用到不该用的地方。</p>
							<p>那么，扁平化究竟该怎么实现怎么应用呢？下文将要做的就是分析扁平化的五个最典型的特征，同时也介绍一下伪扁平化（不含贬义，只是一种折衷的设计方式）。</p>
						</section>
						<section class="recommend">
							<p>延伸阅读</p>
							<p><a href="">推荐！22个超赞的扁平化设计经典案例</a></p>
							<p><a href="">一套最新的扁平化UI组件包免费下载</a></p>
						</section>
						<section class="article_body">
							<h3>一、拒绝特效</h3>
							<img src="../img/article_image.png" alt="aricle_img">
							<p>扁平化这个词来自于这种设计所使用的样式和形状，它完全属于二次元世界，一个简单的形状加没有景深的.</p>
							<p>这个概念最核心的地方就是放弃一切装饰效果，诸如阴影、透视、纹理、渐变等等能做出 3D 效果的元素一概不用。所有的元素的边界都干净俐落，没有任何羽化、渐变或者阴影。</p>

							<h3>二、界面元素</h3>
						</section>
					</article>
					<section id="list">
						<div id="article_list"> 
							<?php foreach ($article_list as $article):?>
								<?php if($article != NULL): ?>
									<div class="article_show">
										<article>
											<header class="article_header">
												<h2><?php echo $article['title']?></h2>
												<p><?php echo $article['time']?> | 阅读: <?php echo $article['num']?></p>
											</header>
											<?php if(@$article['img']!= NULL): ?>
												<img src="<?php echo $article['img']?>" style="width:638px;height:149px">
											<?php endif;?>
											<section class="article_body clearfix">
												<p><?php echo $article['describe']?></p>
												<p class="clearfix read_all"><a href="">阅读全文&#8594;</a></p>	
											</section>	
										</article>
									</div>	
								<?php else :?>
									<p><?php echo '你还没有写文章哦，去后台写一篇呗！'?></p>
								<?php endif?>
							<?php endforeach?>
						</div>
						<div id="navigation">
							<ul class="clearfix">

								<li><a href="">首页</a></li>
								<li><a href=""><<</a></li>
								<li><a href="">1</a></li>
								<?php if($onenum >=2):?>
									<li><a href="">2</a></li>
								<?php endif;?>
								<?php if($onenum >= 5):?>
									<li><a href="">3</a></li>
								<?php endif;?>
								<li><a href="">>></a></li>
								<li><a href="">尾页</a></li>
							</ul>
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