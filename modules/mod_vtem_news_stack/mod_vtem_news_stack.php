<?php
/**
* @Copyright Copyright (C) 2010 VTEM . All rights reserved.
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @link     	http://www.vtem.net
**/

// no direct access
defined('_JEXEC') or die;

// Include the helper functions only once
require_once dirname(__FILE__).DS.'helper.php';

		// Prep for Normal or Dynamic Modes
		$mode = $params->get('mode', 'normal');
		$idbase = null;
		switch($mode)
		{
			case 'dynamic':
				$option = JRequest::getCmd('option');
				$view = JRequest::getCmd('view');
				if ($option === 'com_content') {
					switch($view)
					{
						case 'category':
							$idbase = JRequest::getInt('id');
							break;
						case 'categories':
							$idbase = JRequest::getInt('id');
							break;
						case 'article':
							if ($params->get('show_on_article_page', 1)) {
								$idbase = JRequest::getInt('catid');
							}
							break;
					}
				}
				break;
			case 'normal':
			default:
				$idbase = $params->get('catid');
				break;
		}



$cacheid = md5(serialize(array ($idbase,$module->module)));

$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
$cacheparams->class = 'modVtemNewsStackHelper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$cacheparams->modeparams = $cacheid;

$list = JModuleHelper::moduleCache ($module, $params, $cacheparams);


if (!empty($list)) {
	$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
	$item_heading = $params->get('item_heading');
	
	$document =& JFactory::getDocument();	
    $document->addStyleSheet(JURI::root().'modules/mod_vtem_news_stack/css/styles.css');
    require JModuleHelper::getLayoutPath('mod_vtem_news_stack', $params->get('layout', 'default'));
}
