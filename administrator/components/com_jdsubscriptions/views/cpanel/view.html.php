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

/**
 * View class for control panel.
 */
class JdsubscriptionsViewCpanel extends JViewLegacy {

    protected $buttons;
    protected $version;

    /**
     * Display the view
     */
    public function display($tpl = null) {

        $this->buttons = $this->get('Buttons');
        $this->version = $this->get('version');
        $this->sidebar = $this->get('SideBar');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $input = JFactory::getApplication()->input;
        $view = $input->getCmd('view', '');
        JdsubscriptionsHelper::addSubmenu('cpanel');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        if (JFactory::getUser()->authorise('core.admin', 'com_jdsubscriptions'))
            JToolBarHelper::preferences('com_jdsubscriptions');

        // set title
        JToolBarHelper::title('Jdsubscriptions', 'jdsubscriptions');

        require_once JPATH_COMPONENT . '/helpers/toolbar.php';
        JdsubscriptionsToolbarHelper::addToolbar('jdsubscriptions');
    }

}
