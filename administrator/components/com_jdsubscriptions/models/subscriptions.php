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

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Jdsubscriptions records.
 */
class JdsubscriptionsModelsubscriptions extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'subscription_plan', 'a.subscription_plan',
                'subscriber', 'a.subscriber',
                'status', 'a.status',
                'start_date', 'a.start_date',
                'end_date', 'a.end_date',
                'ordering', 'a.ordering',
                'pp_transaction_id', 'a.pp_transaction_id',
                'state', 'a.state',
                'created_by', 'a.created_by',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);


        //Filtering subscription_plan
        $this->setState('filter.subscription_plan', $app->getUserStateFromRequest($this->context . '.filter.subscription_plan', 'filter_subscription_plan', '', 'string'));

        //Filtering subscriber
        $this->setState('filter.subscriber', $app->getUserStateFromRequest($this->context . '.filter.subscriber', 'filter_subscriber', '', 'string'));

        //Filtering status
        $this->setState('filter.status', $app->getUserStateFromRequest($this->context . '.filter.status', 'filter_status', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_jdsubscriptions');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.subscription_plan', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'a.*'
                )
        );
        $query->from('`#__jdsubscriptions_subscriptions` AS a');


        // Join over the users for the checked out user.
        $query->select('uc.name AS editor');
        $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

        // Join over the foreign key 'subscription_plan'
        $query->select('#__jdsubscriptions_plans_902137.name AS plans_name_902137');
        $query->join('LEFT', '#__jdsubscriptions_plans AS #__jdsubscriptions_plans_902137 ON #__jdsubscriptions_plans_902137.id = a.subscription_plan');
        // Join over the foreign key 'subscriber'
        $query->select('#__jdsubscriptions_subscribers_902138.name AS subscribers_name_902138');
        $query->join('LEFT', '#__jdsubscriptions_subscribers AS #__jdsubscriptions_subscribers_902138 ON #__jdsubscriptions_subscribers_902138.id = a.subscriber');
        // Join over the user field 'created_by'
        $query->select('created_by.name AS created_by');
        $query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');


        // Filter by published state
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('a.state = ' . (int) $published);
        } else if ($published === '') {
            $query->where('(a.state IN (0, 1))');
        }


        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.subscription_plan LIKE ' . $search . '  OR  a.subscriber LIKE ' . $search . '  OR  a.status LIKE ' . $search . '  OR  a.pp_transaction_id LIKE ' . $search . ' )');
            }
        }



        //Filtering subscription_plan
        $filter_subscription_plan = $this->state->get("filter.subscription_plan");
        if ($filter_subscription_plan) {
            $query->where("a.subscription_plan = '" . $db->escape($filter_subscription_plan) . "'");
        }

        //Filtering subscriber
        $filter_subscriber = $this->state->get("filter.subscriber");
        if ($filter_subscriber) {
            $query->where("a.subscriber = '" . $db->escape($filter_subscriber) . "'");
        }

        //Filtering status
        $filter_status = $this->state->get("filter.status");
        if ($filter_status) {
            $query->where("a.status = '" . $db->escape($filter_status) . "'");
        }


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();

        foreach ($items as $oneItem) {

            if (isset($oneItem->subscription_plan)) {
                $values = explode(',', $oneItem->subscription_plan);

                $textValue = array();
                foreach ($values as $value) {
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    $query
                            ->select('name')
                            ->from('`#__jdsubscriptions_plans`')
                            ->where('id = ' . $db->quote($db->escape($value)));
                    $db->setQuery($query);
                    $results = $db->loadObject();
                    if ($results) {
                        $textValue[] = $results->name;
                    }
                }

                $oneItem->subscription_plan = !empty($textValue) ? implode(', ', $textValue) : $oneItem->subscription_plan;
            }

            if (isset($oneItem->subscriber)) {
                $values = explode(',', $oneItem->subscriber);

                $textValue = array();
                foreach ($values as $value) {
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    $query
                            ->select('name')
                            ->from('`#__jdsubscriptions_subscribers`')
                            ->where('id = ' . $db->quote($db->escape($value)));
                    $db->setQuery($query);
                    $results = $db->loadObject();
                    if ($results) {
                        $textValue[] = $results->name;
                    }
                }

                $oneItem->subscriber = !empty($textValue) ? implode(', ', $textValue) : $oneItem->subscriber;
            }
        }
        return $items;
    }

    /**
     * Get the days left
     *
     * @param    none
     * @since    2.0
     */
    public function getDaysleft($sub_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__jdsubscriptions_subscriptions');
        $query->where('id =' . $sub_id);
        //Show published only
        $query->where('state = 1');
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        //Get results list
        $row = $db->loadObject();
        if ($row->start_date < $row->end_date && $row->status == 'active') {
            $now = strtotime("now");
            $endDate = $this->getEndDate($sub_id);
            $difference = ($endDate - $now);
            if (floor($difference / 86400) < 10) {
                return '<span style="color:red">' . floor($difference / 86400) . ' days ' . floor(($difference % 86400) / 3600) . ' hours ' . floor((($difference %
                                86400) % 3600) / 60) . ' minutes ' . (((($difference % 86400) % 3600) % 60)) . ' seconds</span>.';
            } else {
                return '<span style="color:green">' . floor($difference / 86400) . ' days ' . floor(($difference % 86400) / 3600) . ' hours ' . floor((($difference %
                                86400) % 3600) / 60) . ' minutes ' . (((($difference % 86400) % 3600) % 60)) . ' seconds</span>.';
            }
        } else {
            return 'Subscription ' . $row->status;
        }
    }

    /**
     * Get the end date
     *
     * @param    none
     * @since    2.0
     */
    public function getEndDate($sub_id) {
        //Get a db connection.
        $db = JFactory::getDbo();

        //Create a new query object.
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__jdsubscriptions_subscriptions');
        $query->where('id =' . $sub_id);

        //Reset the query using our newly populated query object.
        $db->setQuery($query);

        $row = $db->loadObject();
        return $row->end_date;
    }

    /**
     * Get subscriber id
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    public function getSubscriberId($user_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id');
        $query->from('#__jdsubscriptions_subscribers');
        //Check category
        $query->where('user_id =' . $user_id);
        $db->setQuery($query);
        // Load the results as a list of stdClass objects.
        $row = $db->loadObject();
        return $row->id;
    }

}
