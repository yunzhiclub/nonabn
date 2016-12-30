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

jimport('joomla.application.component.view');

$document = & JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'media/com_jdsubscriptions/css/style.css');
$document->addStyleSheet(JURI::base() . 'media/com_jdsubscriptions/css/jquery-ui-1.10.3.custom.min.css');
$document->addScript(JURI::base() . 'media/com_jdsubscriptions/js/jquery-1.10.2.min.js');
$document->addScript(JURI::base() . 'media/com_jdsubscriptions/js/jquery-ui-1.10.3.custom.min.js');

/**
 * View to edit
 */
class JdsubscriptionsViewMysubscription extends JViewLegacy {

    protected $state;
    protected $item;
    protected $form;
    protected $params;
    protected $subscription;
    protected $subscriber;
    protected $daysleft;

    /**
     * Display the view
     */
    public function display($tpl = null) {

        $app = JFactory::getApplication();
        $user = JFactory::getUser();

        $this->state = $this->get('State');
        $this->item = $this->get('Data');
        $this->params = $app->getParams('com_jdsubscriptions');
        $this->subscription = $this->get('Subscription');
        $this->subscriber = $this->get('Subscriber');
        $this->daysleft = $this->get('Daysleft');
        $this->form = $this->get('Form');

        $this->_prepareDocument();
        parent::display($tpl);
    }

    /**
     * Prepares the document
     */
    protected function _prepareDocument() {
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $title = null;

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('com_jdsubscriptions_DEFAULT_PAGE_TITLE'));
        }
        $title = $this->params->get('page_title', '');
        if (empty($title)) {
            $title = $app->getCfg('sitename');
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
        }
        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }

}
