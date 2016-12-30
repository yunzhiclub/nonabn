<?php
/**
* @Copyright Copyright (C) 2010 VTEM . All rights reserved.
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @link     	http://www.vtem.net
**/
// no direct access
defined('_JEXEC') or die;
$slideID = $params->get( 'slideID','vtemnewsstck1' );
$width = $params->get('width', 680);
$height = $params->get('height', 260);
$largeFeatureWidth = $params->get('largeFeatureWidth', 400);
$largeFeatureHeight = $params->get('largeFeatureHeight', 220);
$smallFeatureWidth = $params->get('smallFeatureWidth', 200);
$smallFeatureHeight = $params->get('smallFeatureHeight', 120);
$topPadding = $params->get('topPadding', 15);
$sidePadding = $params->get('sidePadding', 10);
$smallFeatureOffset = $params->get('smallFeatureOffset', 50);
$startingFeature = $params->get('startingFeature', 1);
$carouselSpeed = $params->get('carouselSpeed', 1000);
$autoPlay = $params->get('autoPlay', 0);
$counterStyle = $params->get('counterStyle', 1);
$preload = $params->get('preload', 1);
$displayCutoff = $params->get('displayCutoff', 0);
$animationEasing = $params->get('animationEasing', 0);
$border = $params->get('border', '1px solid #ddd');
$background = $params->get('background', '#333');
$textcolor = $params->get('textcolor', '#fff');
$activecolor = $params->get('activecolor', '#c00');
$navposition = $params->get('navposition', 4);
$css = $params->get('css');
if($preload ==1){$preload = "true";}else{$preload = "false";}
switch ($navposition) {
	case 1:
		$xposition = "left";
		$yposition = "top";
		break;
	case 2:
		$xposition = "right";
		$yposition = "top";
		break;
	case 3:
		$xposition = "left";
		$yposition = "bottom";
		break;
	case 4:
	default:
		$xposition = "right";
		$yposition = "bottom";
		break;
}

if($params->get('jquery_load') == 1){
echo '<script src="'.JURI::root().'modules/mod_vtem_news_stack/js/jquery-1.5.1.min.js" type="text/javascript"></script>';
}
?>
<script src="<?php echo JURI::root();?>modules/mod_vtem_news_stack/js/script.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
var vtemnewsstack = jQuery.noConflict();
(function($) {
$(function() {
$('#<?php echo $slideID ?>').featureCarousel({
        largeFeatureWidth :     <?php echo $largeFeatureWidth;?>,
        largeFeatureHeight:		<?php echo $largeFeatureHeight;?>,
        smallFeatureWidth:      <?php echo $smallFeatureWidth;?>,
        smallFeatureHeight:		<?php echo $smallFeatureHeight;?>,
        topPadding:             <?php echo $topPadding;?>,
        sidePadding:            <?php echo $sidePadding;?>,
        smallFeatureOffset:		<?php echo $smallFeatureOffset;?>,
        startingFeature:        <?php echo $startingFeature;?>,
        carouselSpeed:          <?php echo $carouselSpeed;?>,
        autoPlay:               <?php echo $autoPlay;?>,
        preload:                <?php echo $preload;?>,
        displayCutoff:          <?php echo $displayCutoff;?>,
        animationEasing:        '<?php echo $animationEasing;?>'
});
});
})(jQuery);
</script>
<style>
#<?php echo $slideID ?>{
width:<?php echo $width;?>px;
height:<?php echo $height;?>px;
display:block;
}
#<?php echo $slideID ?> .carousel-feature{
border:<?php echo $border;?>;
}
#<?php echo $slideID ?> .carousel-feature > div{
background-color:<?php echo $background;?>;
}
#<?php echo $slideID ?> .carousel-feature > div,
#<?php echo $slideID ?> .carousel-feature > div h4,
#<?php echo $slideID ?> .carousel-feature > div a{
color:<?php echo $textcolor;?> !important;
}
.vtem_news_stack .tracker-individual-container{
<?php echo $xposition;?>:<?php echo $sidePadding;?>px;
<?php echo $yposition;?>:<?php echo $smallFeatureOffset / 2;?>px;
}
<?php
echo $css;
?>
</style>
<div class="vtem_news_stack_wapper vtem_counterstyle<?php echo $counterStyle;?>">
 <div id="<?php echo $slideID ?>" class="vtem_news_stack">
	<?php foreach ($list as $key => $item) : ?>
	 <div class="carousel-feature">
	 <?php
	 if($item->displayImage){?>
	  <img class="vt_img_panel" src="<?php echo $item->displayImage;?>" alt="vtem news stack" />
	  <?php }else{
	  echo '<img src="modules/mod_vtem_news_stack/images/noimage.gif" class="vt_img_panel" alt="vtem news stack" />';
	 }?>
	  <div class="carousel-caption">
        <table><tr><td class="vt_main">
	   	<?php echo "<h4 class='vtem_contentheading'>"; ?>
	   	<?php if ($params->get('link_titles') == 1) : ?>
		<a class="vtem_contentpagetitle <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
		<?php echo $item->title; ?>
        <?php if ($item->displayHits) :?>
			<span class="mod-vtem-news-stack-hits">
            (<?php echo $item->displayHits; ?>)  </span>
        <?php endif; ?></a>
        <?php else :?>
        <?php echo $item->title; ?>
        	<?php if ($item->displayHits) :?>
			<span class="mod-vtem-news-stack-hits">
            (<?php echo $item->displayHits; ?>)  </span>
        <?php endif; ?></a>
            <?php endif; ?>
        <?php echo "</h4>"; ?>
       	<?php if ($params->get('show_author')) :?>
       		<span class="mod-vtem-news-stack-writtenby">
			<?php echo $item->displayAuthorName; ?>
			</span>
		<?php endif;?>
		<?php if ($item->displayCategoryTitle) :?>
			<span class="mod-vtem-news-stack-category">
			(<?php echo $item->displayCategoryTitle; ?>)
			</span>
		<?php endif; ?>
        <?php if ($item->displayDate) : ?>
			<span class="mod-vtem-news-stack-date"><?php echo $item->displayDate; ?></span>
		<?php endif; ?>
		<?php if ($params->get('show_introtext')) :?>
			<p class="mod-vtem-news-stack-introtext">
			<?php echo $item->displayIntrotext; ?>
			</p>
		<?php endif; ?>

		<?php if ($params->get('show_readmore')) :?>
			<p class="mod-vtem-news-stack-readmore">
				<a class="readmore_stack <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
		        <?php if ($item->params->get('access-view')== FALSE) :
						echo JText::_('MOD_VTEM_NEWS_STACK_REGISTER_TO_READ_MORE');
					elseif ($readmore = $item->alternative_readmore) :
						echo $readmore;
						echo JHTML::_('string.truncate', $item->title, $params->get('readmore_limit'));
					elseif ($params->get('show_readmore_title', 0) == 0) :
						echo JText::sprintf('MOD_VTEM_NEWS_STACK_READ_MORE_TITLE');	
					else :
						echo JText::_('MOD_VTEM_NEWS_STACK_READ_MORE');
						echo JHTML::_('string.truncate', $item->title, $params->get('readmore_limit'));
					endif; ?>
	        </a>
			</p>
		<?php endif; ?>
		</td></tr></table>	
	  </div>
	</div>
	<?php endforeach; ?>
 </div>
 <div style="clear:both"></div>
</div>
