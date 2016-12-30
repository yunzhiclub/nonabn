<?php
/**
 * @version     1.0
 * @package     com_jdsubscriptions
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @author      Brad Traversy <support@joomdigi.com> - http://www.joomdigi.com
 */

// No direct access.
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_jdsubscriptions')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

// set default view if not set
JRequest::setVar('view', JRequest::getCmd('view', 'CPanel'));

$controller	= JControllerLegacy::getInstance('Jdsubscriptions');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
