<?php
  require('auth.php');
?>
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
    <?php
    	$baseUrl= base_url();
    	if(isset($article))
    	{	
    		$isArticle = TRUE;
    		$article_title = $article[0]['atitle'];
    		$detailid = $article[0]['detailid'];	
    	}
    	
    ?>
    <link rel="stylesheet" href="<?php echo $baseUrl."css/master.css"?>">
	<link rel="stylesheet" href="<?php echo $baseUrl."css/component/YUI_reset.css"?>">
	<script src="<?php echo $baseUrl."js/components/jquery.js"?>"></script>
	<!-- xhedit插件引入 -->
	<script type="text/javascript" src="<?php echo $baseUrl."js/components/TQEditor.js"?>"></script>
</head>
<body>

	<div id="wrap">
		<?php $this->load->view("public/header");?>
		<div id="header_content">
			<header>
				<div>
					<a class="back_write" href="<?php echo $baseUrl."/master/write"?>">撰写blog</a>
					<ul>
						<li><a id="write_ok" href=""><img src="<?php echo $baseUrl."img/back_ok.png"?>" alt="ok"></a></li>
						<li><a <?php  if (isset($article)): ?>href="<?php echo $baseUrl."master/update/$detailid"?>"<?php endif;?>>><img src="<?php echo $baseUrl."img/back_modify.png"?>" alt="modify"></a></li>
						<li><a id="write_delete" <?php  if (isset($article)): ?>href="<?php echo $baseUrl."master/delete/$detailid"?>"<?php endif;?>><img src="<?php echo $baseUrl."img/back_delete.png"?>" alt="delete"></a></li>
					</ul>
				</div>
			</header>
			<section id="content" class="clearfix">
				<aside>
					<div id="about_design">
						<a class="about_me_tag" href="">设计篇（<span>0</span>）</a>
						<ul>
							<li class="save_time">存档时间:</li>
							<li class="time time_now"><a href="">2013 年</a></li>
							<li class="time"><a href="">2014 年</a></li>
							<li class="time"><a href="">2015 年</a></li>
							<li class="time"><a href="">2016 年</a></li>
						</ul>
					</div>
					<div id="about_me">
						<a class="about_me_tag" href="">个人篇（<span>1</span>）</a>
						<ul>
							<li class="save_time">存档时间:</li>
							<li class="time"><a href="">2013 年</a></li>
							<li class="time"><a href="">2014 年</a></li>
							<li class="time"><a href="">2015 年</a></li>
							<li class="time"><a href="">2016 年</a></li>
						</ul>
					</div>
					<div id="about_road">
						<a class="about_me_tag" href="">读书上路（<span>0</span>）</a>
						<ul>
							<li class="save_time">存档时间:</li>
							<li class="time"><a href="">2013 年</a></li>
							<li class="time"><a href="">2014 年</a></li>
							<li class="time"><a href="">2015 年</a></li>
							<li class="time"><a href="">2016 年</a></li>
						</ul>
					</div>
				</aside>

				<?php if (!isset($isWrite) || !isset($isUpdate)): ?>
					<div class="back_article">
						<article >
							
							<div class="back_article_header">
								<h2><?php echo $article[0]['atitle']?></h2>
								<time><?php echo $article[0]['atime']?>｜<?php echo $article[0]['anum']?></time>
							</div>
							<section>
								<?php echo $article[0]['abody']?>								
							</section>
						</article>
						<div class="article_list">
							<ul>
								<div class="back_article_header">
									<h2>推荐！22个超赞的扁平化设计经典案例</h2>
									<time>2013/04/02｜21</time>
								</div>
								<section>
									<p>不难发现，有一个新的简约设计趋势(风格)正向我们袭来。想必大家已经猜到咯，Flat Design！刚刚改版的新浪首页也更加简洁干练，扁平透气的风格也让很多小网龄用户感觉潮...</p>
								</section>
							</ul>
							<ul>
								<div class="back_article_header">
									<h2>推荐！22个超赞的扁平化设计经典案例</h2>
									<time>2013/04/02｜21</time>
								</div>
								<section>
									<p>不难发现，有一个新的简约设计趋势(风格)正向我们袭来。想必大家已经猜到咯，Flat Design！刚刚改版的新浪首页也更加简洁干练，扁平透气的风格也让很多小网龄用户感觉潮...</p>
								</section>
							</ul>
						</div>
					</div>
				<?php endif; ?>
				
				
				<?php if (isset($isWrite) || isset($isUpdate)): ?>
					<div id="addArticle">

						<form id="add_form" action="<?php if(isset($isWrite)):?> <?php echo $baseUrl."/master/save"?><?php else;?><?php echo $baseUrl."/master/update_article"?><?php endif; ?>" method="post" name="add_form">
						
							<fieldset>
								<legend>addArticle</legend>
								<p>
									<label for="add_title">标题</label>
									<input type="text" id="add_title" name="add_title" <?php  if (isset($update_title)): ?>value="<?php echo $update_title ?>"<?php endif;?> autofocus>
								</p>
								<p>
									<label for="add_achieve">归类</label>
									<select name="add_achieve" id="add_achieve">
										<option value="设计篇"  <?php  if (isset($update_type) &&  $update_type == 1): ?>selected="selected"<?php endif;?> >设计篇</option>
										<option value="个人篇" <?php  if (isset($update_type) &&  $update_type == 2): ?>selected="selected"<?php endif;?>>个人篇</option>
										<option value="读书上路" <?php  if (isset($update_type) && $update_type == 3): ?>selected="selected"<?php endif;?>>读书上路</option>
									</select>
								</p>
								
								<p>
									<label for="add_tag">标签</label>
									<input type="text" id="add_tag" <?php  if (isset($update_tag)): ?>value="<?php echo $update_tag ?>"<?php endif;?> name="add_tag" placeholder="多个标签用逗号隔开">
									<p id="oldTag">

										<?php foreach ($tags as $tag) :?>
											<span><?php echo $tag['tagbody'] ?></span>
										<?php endforeach; ?>
									</p>
								</p>
								
								<textarea id="write" name="content" class="xheditor" rows="10" cols="80"><?php  if (isset($update_content)): ?><?php echo $update_content ?><?php endif;?></textarea>
								<script type="text/javascript" defer="true"> 
									// 自定义ＴＱＥｄｉｔｏｒ的图标
									var tqEditor = new tqEditor('write',{toolbar:['paragraph','fontname','fontsize','forecolor','backcolor','bold','italic','underline','strikethrough','|','justifyleft','justifycenter','justifyright','unorderedlist','iodent','outdent','indent','inserhorizontalrule','createlink','unlink','subscript','superscript','|','inserttable','insertface','insertimage'],toolbarRight:['fullscreen','help']}); 
								</script>
							</fieldset>
						</form>
					</div>
				<?php endif; ?>
			</section>	
		</div>
		
		<footer>
			
		</footer>	
	</div>
	
	<script src="<?php echo $baseUrl."js/master.js"?>"></script>
</body>
</html>