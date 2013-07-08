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
	<!--[if lt IE 9]>
<div class = "ltie">
    <p>您的浏览器已经过时了，为了更好的浏览体验，请下载<a href = 'http://www.google.co.kr/intl/zh-CN/chrome/browser/'>chrome</a>或<a href = 'http://www.mozilla.org/en-US/firefox/new/' >firefox</a>浏览器 ~ ~ </p>
</div>
<![endif]--> 
	<section id="wrap">
		<?php $this->load->view("public/header");?>
		
		<div id="message_body">
			<div id="message_main">
				<div class="message_list">
					<img src="../img/message_guest.gif">
					<div class="say">
						<p><span class="message_orange">sam</span>: 随便写点测试</p>
						<p>
							<span class="message_time">2013-07-08 11:08</span>
							<a href="" class="message_orange msg_response">[回复]</a>
						</p>
					</div>
				</div>
				<div class="message_list">

					<img src="../img/message_guest.gif">
					<div class="say">
						<p><span class="message_orange">fs21</span>: 随便写点测试</p>
						<p>
							<span class="message_time">2013-07-08 11:07</span>
							<a href="" class="msg_response message_orange">[回复]</a>
						</p>
					</div>
					<div class="message_response">
						<img src="../img/message_host.png">
						<div class="say">
							<p>
								<span class="message_orange">sam</span>
								    回复 <span class="message_orange">xxx</span>
								    : 随便写点测试随便写点测试随便写点测试随便写点测试随便写点测试随便写点测试
							</p>
							<p>
								<span class="message_time">2013-02-20 00:00</span>
								<a href="" class="msg_response message_orange">[回复]</a>
							</p>
						</div>
					</div>
				</div>
			</div>
			<div id="message_sider">
				<form action="#" method="post" class="msg_form">
					<fieldset>
						<legend>message</legend>
						<p class="nickname">
							<label for="nickname">nickname</label>
							<input id="nickname" type="text" name="nickname">
							<span class="placeholder">nickname</span>
						</p>
						<p class="email">
							<label for="email">email</label>
							<input type="text" name="email" id="email">
							<span class="placeholder">email</span>
						</p>
						<p class="blog">
							<label for="blog">blog</label>
							<input type="text" name="blog" id="blog">
							<span class="placeholder">blog</span>
						</p>
						<textarea name="message_content" id="message_content" cols="22" rows="5"></textarea>
						<span class="textarea_placeholder">something to say</span>
						<input type="submit" value="留言" id="msg_submit">
						<a href="#" id="update_msg_list">刷新留言列表，我是隐藏的</a>
						
					</fieldset>
				</form>
			</div>
		</div>
		
		<section id="welcome">
			<div id="welcome_text">
				<span>”</span>
				<p>Welcome</p>
			</div>
			<div class="welcome_article">
				<?php if(isset($nearst_list[0]['img'])): ?>
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
			<div id="submain"> <!-- 好处:点击welcome动画后文章不会在最下面动 -->
				<aside id="achieve">
					<ul class="achieve_nav clearfix">
						<li ><a href="">设计篇(<?php echo $num_design?>)</a></li>
						<li class="achieve_nav_active"><a href="">个人篇(<?php echo $num_person?>)</a></li>
						<li><a href="">读书上路(<?php echo $num_read?>)</a></li>
					</ul>
					
					<a href="" class="list_taggle_outer">
						<canvas id="list_taggle" width="35" height="35"></canvas>
					</a>

					<!-- 常用的几个标签 -->
					<ul class="achieve_item achieve_tag clearfix">
						<li class="achieve_item_tag">标签</li>
						<li class="tag_big"><a data-value="1" href="">PSD</a></li>
						<li class="tag_small"><a data-value="2" href="">UI</a></li>
						<li class="tag_big"><a data-value="3" href="">网页设计</a></li>
						<li class="tag_big"><a data-value="4" href="">用户体验</a></li>
						<li class="tag_small"><a data-value="5" href="">好文</a></li>
						<li class="tag_small"><a data-value="6" href="">界面设计</a></li>
					</ul>
					<!-- 离现在最近的四个月 -->
					<ul class="achieve_item achieve_time clearfix">
						<li class="achieve_item_tag">存档时间</li>
						<?php if($achieve_time) :?>
							<?php foreach ($achieve_time as $key => $value) :?>
								<li class="time"><a data-value="<?php echo $value['year']?>-<?php echo $value['month']?>" href=""><?php echo $value['year']?> 年<?php echo $value['month']?>月</a></li>
							<?php endforeach ;?>
						<?php endif;?>
						
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
						<?php if($nearst_list != NULL):?>
							<header class="article_header">
								<h2><?php echo $nearst_list[0]['title'] ?></h2>
								<p><?echo $nearst_list[0]['time']?> | 阅读: <?php echo $nearst_list[0]['num']?></p>
							</header>
							<section class="article_body">
								<?php echo $nearst_list[0]['body']?>
							</section>
						<?php else :?>
							<header class="article_header">
								<p>你还没有写文章哦！</p>
							</header>
						<?php endif;?>
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