<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Maximenu CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die;
jimport('joomla.filesystem.file');
require_once dirname(__FILE__) . '/helper.php';

// retrieve menu items
$thirdparty = $params->get('thirdparty', 'none');
switch ($thirdparty) :
	default:
	case 'none':
		// Include the syndicate functions only once
		// require_once dirname(__FILE__).'/helper.php';
		$items = modMaximenuckHelper::getItems($params);
		break;
	case 'virtuemart':
		// Include the syndicate functions only once
		if (JFile::exists(dirname(__FILE__) . '/helper_virtuemart.php')) {
			require_once dirname(__FILE__) . '/helper_virtuemart.php';
			$items = modMaximenuckvirtuemartHelper::getItems($params);
		} else {
			echo '<p style="color:red;font-weight:bold;">File helper_virtuemart.php not found ! Please download the patch for Maximenu - Virtuemart on <a href="http://www.joomlack.fr">http://www.joomlack.fr</a></p>';
			return false;
		}
		break;
	case 'hikashop':
		// Include the syndicate functions only once
		if (JFile::exists(dirname(__FILE__) . '/helper_hikashop.php')) {
			require_once dirname(__FILE__) . '/helper_hikashop.php';
			$items = modMaximenuckhikashopHelper::getItems($params);
		} else {
			echo '<p style="color:red;font-weight:bold;">File helper_hikashop.php not found ! Please download the patch for Maximenu - Hikashop on <a href="http://www.joomlack.fr">http://www.joomlack.fr</a></p>';
			return false;
		}
		break;
	case 'k2':
		// Include the syndicate functions only once
		if (JFile::exists(dirname(__FILE__) . '/helper_k2.php')) {
			require_once dirname(__FILE__) . '/helper_k2.php';
			$items = modMaximenuckk2Helper::getItems($params);
		} else {
			echo '<p style="color:red;font-weight:bold;">File helper_k2.php not found ! Please download the patch for Maximenu - K2 on <a href="http://www.joomlack.fr">http://www.joomlack.fr</a></p>';
			return false;
		}
		break;
endswitch;

// if no item in the menu then exit
if (!count($items) OR !$items)
	return false;


$document = JFactory::getDocument();
$app = JFactory::getApplication();
$menu = $app->getMenu();
$active = $menu->getActive();
$active_id = isset($active) ? $active->id : $menu->getDefault()->id;
$path = isset($active) ? $active->tree : array();
$class_sfx = htmlspecialchars($params->get('class_sfx'));
jimport('joomla.plugin.helper');

// get the language direction
$langdirection = $document->getDirection();

// page title management
if ($active) {
	$pagetitle = $document->getTitle();
	$title = $pagetitle;
	if (preg_match("/||/", $active->title)) {
		$title = explode("||", $active->title);
		$title = str_replace($active->title, $title[0], $pagetitle);
	}
	if (preg_match("/\[/", $active->title)) {
		if (!$title)
			$title = $active->title;
		$title = explode("[", $title);
		$title = str_replace($active->title, $title[0], $pagetitle);
	}
	$document->setTitle($title); // returns the page title without description
}


// retrieve parameters from the module
// params for the script
$mooduree = $params->get('mooduration', 500);
$moodureeout = $params->get('moodurationout', 500);
$mootransition = $params->get('mootransition', 'Bounce');
$mooease = $params->get('mooease', 'easeOut');
$usemootools = $params->get('usemootools', '1');
$orientation = $params->get('orientation', '0');
$testoverflow = $params->get('testoverflow', '0');
$opentype = $params->get('opentype', 'open');
$direction = $params->get('direction', 'normal');
$directionoffset1 = $params->get('directionoffset1', '30');
$directionoffset2 = $params->get('directionoffset2', '30');

$style = $params->get('style', 'moomenu');
$usecss = $params->get('usecss', '1');
$menuID = $params->get('menuid', 'maximenuck');
$usefancy = $params->get('usefancy', '1');
$fancyduree = $params->get('fancyduration', 500);
$fancytransition = $params->get('fancytransition', 'Sine');
$fancyease = $params->get('fancyease', 'easeOut');
$theme = $params->get('theme', 'default');
$fxtype = $params->get('fxtype', 'open');
$useopacity = $params->get('useopacity', '0');
$dureein = $params->get('dureein', 0);
$dureeout = $params->get('dureeout', 500);
$showactivesubitems = $params->get('showactivesubitems', '0');
$menubgcolor = $params->get('menubgcolor', '') ? "background:" . $params->get('menubgcolor', '') : '';
$load = $params->get('load', 'domready');
$ismobile = '0';
$logoimage = $params->get('logoimage', '');
$logolink = $params->get('logolink', '');
$logoheight = $params->get('logoheight', '');
$logowidth = $params->get('logowidth', '');
$effecttype = ($params->get('layout', 'default') == '_:pushdown') ? 'pushdown' : 'dropdown';

if ($effecttype == 'pushdown' && $orientation == '1') {
	echo '<p style="color:red;font-weight:bold;">MAXIMENU MESSAGE : You can not use the Pushdown layout for a Vertical menu</p>';
	return false;
}

if (isset($_SERVER['HTTP_USER_AGENT']) && (strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPad') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPod') || strstr($_SERVER['HTTP_USER_AGENT'], 'Android'))) {
	$style = 'click';
	$ismobile = '1';
}

// set color css
$menustyles = '';
if ($titlescolor = $params->get('titlescolor', ''))
	$menustyles .= "div#" . $menuID . " ul.maximenuck li.maximenuck > a span.titreck {color:" . $titlescolor . " !important;} div#" . $menuID . " ul.maximenuck li.maximenuck > span.separator span.titreck {color:" . $titlescolor . " !important;}";
if ($descscolor = $params->get('descscolor', ''))
	$menustyles .= "div#" . $menuID . " ul.maximenuck li.maximenuck > a span.descck {color:" . $descscolor . " !important;} div#" . $menuID . " ul.maximenuck li.maximenuck > span.separator span.descck {color:" . $descscolor . " !important;}";
if ($titleshovercolor = $params->get('titleshovercolor', ''))
	$menustyles .= "div#" . $menuID . " ul.maximenuck li.maximenuck > a:hover span.titreck {color:" . $titleshovercolor . " !important;} div#" . $menuID . " ul.maximenuck li.maximenuck > span.separator:hover span.titreck {color:" . $titleshovercolor . " !important;}";
if ($descshovercolor = $params->get('descshovercolor', ''))
	$menustyles .= "div#" . $menuID . " ul.maximenuck li.maximenuck > a:hover span.descck {color:" . $descshovercolor . " !important;} div#" . $menuID . " ul.maximenuck li.maximenuck > span.separator:hover span.descck {color:" . $descshovercolor . " !important;}";
if ($menustyles)
	$document->addStyleDeclaration($menustyles);

// add external stylesheets
if ($orientation == 1) {
	if ($langdirection == 'rtl' && JFile::exists(dirname(__FILE__) . '/themes/' . $theme . '/css/moo_maximenuvck_rtl.css')) {
		$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/themes/' . $theme . '/css/moo_maximenuvck_rtl.css');
	} else {
		$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/themes/' . $theme . '/css/moo_maximenuvck.css');
	}
	if ($usecss == 1) {
		if ($langdirection == 'rtl' && JFile::exists(dirname(__FILE__) . '/themes/' . $theme . '/css/maximenuvck_rtl.php')) {
			$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/themes/' . $theme . '/css/maximenuvck_rtl.php?monid=' . $menuID);
		} else {
			$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/themes/' . $theme . '/css/maximenuvck.php?monid=' . $menuID);
		}
	}
} else {
	if ($langdirection == 'rtl' && JFile::exists(dirname(__FILE__) . '/themes/' . $theme . '/css/moo_maximenuhck_rtl.css')) {
		$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/themes/' . $theme . '/css/moo_maximenuhck_rtl.css');
	} else {
		$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/themes/' . $theme . '/css/moo_maximenuhck.css');
	}
	if ($usecss == 1) {
		if ($langdirection == 'rtl' && JFile::exists(dirname(__FILE__) . '/themes/' . $theme . '/css/maximenuhck_rtl.php')) {
			$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/themes/' . $theme . '/css/maximenuhck_rtl.php?monid=' . $menuID);
		} else {
			$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/themes/' . $theme . '/css/maximenuhck.php?monid=' . $menuID);
		}
	}
}

if (JFile::exists('modules/mod_maximenuck/themes/' . $theme . '/css/ie7.css')) {
	echo '
		<!--[if lte IE 7]>
		<link href="' . JURI::base(true) . '/modules/mod_maximenuck/themes/' . $theme . '/css/ie7.css" rel="stylesheet" type="text/css" />
		<![endif]-->';
}
$menuposition = $params->get('menuposition', '0');
if ($menuposition) {
	$fixedcssposition = ($menuposition == 'bottomfixed') ? "bottom: 0 !important;" : "top: 0 !important;";
	$fixedcss = "div#" . $menuID . ".maximenufixed {
        position: fixed !important;
        left: 0 !important;
        " . $fixedcssposition . "
        right: 0 !important;
        z-index: 1000 !important;
    }";
	if ($menuposition == 'topfixed') {
		$fixedcss .= "div#" . $menuID . ".maximenufixed ul.maximenuck {
            top: 0 !important;
        }";
	} else if ($menuposition == 'bottomfixed') {
		$direction = 'inverse';
	}
//$topfixedmenu = $params->get('topfixedmenu', '0');
	//if ($topfixedmenu)
	$document->addStyleDeclaration($fixedcss);
}
// get the css from the plugin params and inject them
if (JPluginHelper::isEnabled('system', 'maximenuckparams')) {
	modMaximenuckHelper::injectModuleCss($params, $menuID);
}

// add compatibility css for templates
$templatelayer = $params->get('templatelayer', 'beez_20-position1');
if ($usecss == 1 AND $templatelayer != -1)
	$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/templatelayers/' . $templatelayer . '.css');

// add responsive css
if ($orientation == 0 && $params->get('useresponsive', '1') == '1')
	$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/assets/maximenuresponsiveck.css');


// add mootools effects
if ($usemootools == 1 && $params->get('layout', 'default') != '_:flatlist' && $params->get('layout', 'default') != '_:nativejoomla' && $params->get('layout', 'default') != '_:dropselect') {
	// load mootools core and more
	JHTML::_("behavior.framework", true);
	$document->addScript(JURI::base(true) . '/modules/mod_maximenuck/assets/moomaximenuck.js');

	// load moomenu
	$js = "window.addEvent('" . $load . "', function() {new DropdownMaxiMenu(document.getElement('div#" . $menuID . "'),{"
			. "mooTransition : '" . $mootransition . "',"
			. "mooEase : '" . $mooease . "',"
			. "useOpacity : '" . $useopacity . "',"
			. "dureeIn : " . $dureein . ","
			. "dureeOut : " . $dureeout . ","
			. "menuID : '" . $menuID . "',"
			. "testoverflow : '" . $testoverflow . "',"
			. "orientation : '" . $orientation . "',"
			. "style : '" . $style . "',"
			. "opentype : '" . $opentype . "',"
			. "direction : '" . $direction . "',"
			. "directionoffset1 : '" . $directionoffset1 . "',"
			. "directionoffset2 : '" . $directionoffset2 . "',"
			. "mooDureeout : '" . $moodureeout . "',"
			. "showactivesubitems : '" . $showactivesubitems . "',"
			. "ismobile : " . $ismobile . ","
			. "menuposition : '" . $menuposition . "',"
			. "langdirection : '" . $langdirection . "',"
			. "effecttype : '" . $effecttype . "',"
			. "mooDuree : " . $mooduree . "});"
			. "});";

	$document->addScriptDeclaration($js);
} else if ($params->get('layout', 'default') != '_:flatlist') {
	$document->addStyleSheet(JURI::base(true) . '/modules/mod_maximenuck/assets/maximenuck.css');
	$script = '<!--
				if (window.attachEvent) window.attachEvent("onload", function() {
				var sfEls = document.getElementById("' . $menuID . '").getElementsByTagName("li");
				for (var i=0; i<sfEls.length; i++) {

					sfEls[i].onmouseover=function() {
						this.className+=" sfhover";
					}

					sfEls[i].onmouseout=function() {
						this.className=this.className.replace(new RegExp(" sfhover\\\\b"), "");
					}
				}
				});
				//-->';
	$document->addScriptDeclaration($script);
}

// add fancy effect
if ($usemootools == 1 && $orientation != 1 && $usefancy == 1) {
	$document->addScript(JURI::base(true) . '/modules/mod_maximenuck/assets/fancymenuck.js');
	$js = "window.addEvent('domready', function() {new SlideList(document.getElement('div#" . $menuID . " ul'),{"
			. "fancyTransition : '" . $fancytransition . "',"
			. "fancyEase : '" . $fancyease . "',"
			. "fancyDuree : " . $fancyduree . "});"
			. "});";
	$document->addScriptDeclaration($js);
}

require JModuleHelper::getLayoutPath('mod_maximenuck', $params->get('layout', 'default'));