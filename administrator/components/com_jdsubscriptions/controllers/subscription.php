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

jimport('joomla.application.component.controllerform');

/**
 * Subscription controller class.
 */
class JdsubscriptionsControllerSubscription extends JControllerForm
{

    function __construct() {
        $this->view_list = 'subscriptions';
        parent::__construct();
         //Get form data
        $data = JRequest::getVar('jform', array(), 'post', 'array');

        //Instantiate model
        $model = $this->getModel('subscription');
    }

}