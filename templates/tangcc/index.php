<?php
defined('_JEXEC') or die;

/* The following line loads the MooTools JavaScript Library */
JHtml::_('behavior.framework', true);

/* The following line gets the application object for things like displaying the site name */
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$lang = JFactory::getLanguage();
$user = JFactory::getUser();
$menu = $app->getMenu();
$menuActive   = $menu->getActive();
$itemId = $menuActive->id;
?>
<?php echo '<?'; ?>xml version="1.0" encoding="<?php echo $this->_charset ?>"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/theme.css" type="text/css" />
<!--页面为联系我们(content us)则引入baidu地址API-->
<?php if($itemId == 149 || $itemId == 199) : ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
<?php endif; ?>
</head>

<style type="text/css">
/*按是否登陆确定菜单子项的宽度，使菜单子项充满整个菜单
	#menu li a {
		 padding-right: <?php if($user->guest) echo "21";else echo "16"; ?>px; 
		 padding-left: <?php if($user->guest) echo "21";else echo "16"; ?>px;
	}*/
</style>
<body>
	<div id="content">
	
	<?php if($this->countModules('position-7')) : ?>
		<jdoc:include type="modules" name="position-7" style="none" />
	<?php endif; ?>
	<!--LOGO-->
		<div id="logo" class="logo-zh"></div>
	<?php 
		if($this->countModules('menu')) : ?>
		<!--菜单-->
		<div id="menu">
		<jdoc:include type="modules" name="menu" style="none" />
		</div><!--menu-->
	<?php endif;?>
<div class="clear"></div>
		<div id="main">
		<!--左侧页面设置-->
			<div id="left" class="<?php if($menu->getActive() == $menu->getDefault('zh-CN') || $menu->getActive() == $menu->getDefault('en-GB')) echo "home-left"; else echo "contents-left"; ?>" >
			<?php
			$papers = "发表论文";
			$workReports = "工作汇报";
			$searchFiled = "中心简介";
			$members = "研究成员";
			$share = "资源共享";
			$results = "研究成果";
			$homeNews = "新闻通知";
			$activities = "休闲活动";
			$hots = "热点新闻";
			$news = "最新新闻"; 
			$login = "用户登陆";
			//英文首页字段设置
			if($menu->getActive() == $menu->getDefault('en-GB'))
			{
				$papers = "PAPERS";
				$workReports = "WORK REPORTS";
				$login = "LOGIN";
				$searchFiled = "ABOUT US";
				$members = "MEMBERS";
				$share = "SHARE";
				$results = "RESEARCH RESULTS";
				$homeNews = "NEWS";
				$activities = "ACTIVITIES";
			}
			//英文子页面字段设置
			if( $lang->getName() == "English (United Kingdom)")
			{
				$hots = "HOTS";
				$news = "NEWS";
				$login = "LOGIN";
			}
			//首页字段设置
			if($menu->getActive() == $menu->getDefault('zh-CN') || $menu->getActive() == $menu->getDefault('en-GB')) 
			{
				
				if($this->countModules('home-news')) : ?>
				<h1 class="h-right"><?=$homeNews?></h1>
				<!--首页新闻通知-->
				<div id="xwtz">					
					<jdoc:include type="modules" name="home-news" style="none" />
					<div class="clear"></div>
				</div><!--xwtz-->
				<div class="clear"></div>
				<?php endif;			
			}//主页模板LEFT部分结束
			else
			{
				if($this->countModules('left-menu')) : ?>
				<jdoc:include type="modules" name="left-menu" style="none" />
				<div class="clear"></div>
				<?php endif; 
				if($this->countModules('login')) : ?>
				<h1><?=$login?></h1>
				<jdoc:include type="modules" name="login" style="none" />
				<div class="clear"></div>
				<?php endif;
				if($this->countModules('hots')) : ?>
				<h1><?=$hots?></h1>
				<jdoc:include type="modules" name="hots" style="none" />
				<div class="clear"></div>
				<?php endif; ?>
				<?php if($this->countModules('news')) : ?>
				<h1><?=$news?></h1>
				<jdoc:include type="modules" name="news" style="none" />
				<?php endif;
			}
			?>
			<div class="clear"></div>
			</div>
			<!--中部、右侧页面设置-->
			<div id="right" class="<?php if($menu->getActive() == $menu->getDefault('zh-CN') || $menu->getActive() == $menu->getDefault('en-GB')) echo "home-right"; else echo "contents-right" ?>">
			<?php if($menu->getActive() == $menu->getDefault('zh-CN') || $menu->getActive() == $menu->getDefault('en-GB'))
			{
				?>
				<!--中部页面设置-->
				<div id="rightCenter">
				<?php if($this->countModules('searchFiled')) : ?>
				<h1 class="h-center"><?=$searchFiled?></h1>
				<!--首页中心简介-->
				<div id="yjly">
				<jdoc:include type="modules" name="home-silder" style="none" />
				<jdoc:include type="modules" name="searchFiled" style="none" />
				
				<div class="clear"></div>
				</div><!--yjly-->
				<div class="clear"></div>
				<?php endif; ?>		
				</div><!--rightCenter-->
				<!--右侧页面设置-->
				
				<div class="clear"></div>
			<?php
			}
			else
			{
			?>
			<!--主页模板结束-->
			<!--面包屑-->
			<div id="nav">
				<jdoc:include type="modules" name="nav" style="none" />
			</div><!--nav-->
			<!--引入内容页-->
			<!--?php echo $itemId; ?-->
			<?php if($this->countModules('content')) : ?>
			<div>
			<jdoc:include type="modules" name="content"  style="none" />
			</div>
			<div class="clear"></div>
			<?php endif; ?>
				<jdoc:include type="component" />
			<?php
			}//end else
			?>
			<div class="clear"></div>
			</div><!--right-->
			<div class="clear"></div>
		</div><!--main-->
		<div class="clear"></div>
		<div id="footer">
		<div class="clear"></div>
<jdoc:include type="modules" name="footer" style="none" />
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	</body>
	<?php 
	if($itemId == 149 || $itemId == 199)
	{
		include("js/baiduMap.php");
	}
	?>
</html>