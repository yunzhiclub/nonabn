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

jimport('joomla.application.component.controlleradmin');

/**
 * Messages list controller class.
 */
class JdsubscriptionsControllerCpanel extends JControllerAdmin {

    function __construct() {
        parent::__construct();
    }      

    /**
     * Proxy for getModel.
     * @since	1.6
     */
    public function getModel($name = 'cpanel', $prefix = 'JdsubscriptionsModel') {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

}