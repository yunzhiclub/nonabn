<?php
/**
 * @version     1.0
 * @package     com_jdsubscriptions
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Brad Traversy <support@joomdigi.com> - http://www.joomdigi.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

//Require Helper
require_once JPATH_COMPONENT . '/helpers/jdsubscriptions.php';
/**
 * Methods supporting a list of Jdsubscriptions records.
 */
class JdsubscriptionsModelMysubscriptions extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);
        //Check login and redirect
        //JdsubscriptionsHelper::checkLogin('index.php','You need to be logged in to view this area','error');
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);

        $limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);

        if (empty($ordering)) {
            $ordering = 'a.ordering';
        }

        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Get users subscriptions
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        $user = JFactory::getUser();
        $user_id = $user->id;
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', '*'
                )
        );
        $query->from('`#__jdsubscriptions_subscriptions` AS a');
        $query->leftjoin('`#__jdsubscriptions_plans` AS b ON a.subscription_plan = b.id');
        $query->where("a.subscriber = '" . $user_id . "'");
        //echo $query;die();
        return $query;
    }

    public function getItems() {
        return parent::getItems();
    }
    
    public function getSubscriptionId($plan_id,$subscriber){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__jdsubscriptions_subscriptions');
        $query->where('subscription_plan =' . $plan_id);
        $query->where('subscriber =' . $subscriber);
        //Show published only
        $query->where('state = 1');
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        // Load the results as a list of stdClass objects.
        $results = $db->loadObjectList();
        return $results[0]->id;
    }

}
