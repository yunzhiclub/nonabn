<?php

/**
 * @version     1.0
 * @package     com_jdsubscriptions
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Brad Traversy <support@joomdigi.com> - http://www.joomdigi.com
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

$document = & JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'media/com_jdsubscriptions/css/style.css');

/**
 * View to edit
 */
class JdsubscriptionsViewProcess extends JViewLegacy {

    protected $item;
    protected $params;
    protected $subscriptionplan;
    protected $subscriber;
    protected $subscription;

    /**
     * Display the view
     */
    public function display($tpl = null) {

        $app = JFactory::getApplication();
        $user = JFactory::getUser();

        $this->state = $this->get('State');
        $this->item = $this->get('Data');
        $this->subscriptionplan = $this->get('SubscriptionPlan');
        $this->subscriber = $this->get('Subscriber');
        $this->subscription = $this->get('Subscription');

        $this->params = $app->getParams('com_jdsubscriptions');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        parent::display($tpl);
    }

}
