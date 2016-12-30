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

jimport('joomla.application.component.modeladmin');

/**
 * Jdsubscriptions model.
 */
class JdsubscriptionsModelsubscription extends JModelAdmin {

    /**
     * @var		string	The prefix to use with controller messages.
     * @since	1.6
     */
    protected $text_prefix = 'COM_JDSUBSCRIPTIONS';

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param	type	The table type to instantiate
     * @param	string	A prefix for the table class name. Optional.
     * @param	array	Configuration array for model. Optional.
     * @return	JTable	A database object
     * @since	1.6
     */
    public function getTable($type = 'Subscription', $prefix = 'JdsubscriptionsTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param	array	$data		An optional array of data for the form to interogate.
     * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
     * @return	JForm	A JForm object on success, false on failure
     * @since	1.6
     */
    public function getForm($data = array(), $loadData = true) {
        // Initialise variables.
        $app = JFactory::getApplication();

        // Get the form.
        $form = $this->loadForm('com_jdsubscriptions.subscription', 'subscription', array('control' => 'jform', 'load_data' => $loadData));


        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return	mixed	The data for the form.
     * @since	1.6
     */
    protected function loadFormData() {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_jdsubscriptions.edit.subscription.data', array());

        if (empty($data)) {
            $data = $this->getItem();


            //Support for multiple or not foreign key field: subscription_plan
            $array = array();
            foreach ((array) $data->subscription_plan as $value):
                if (!is_array($value)):
                    $array[] = $value;
                endif;
            endforeach;
            $data->subscription_plan = implode(',', $array);

            //Support for multiple or not foreign key field: subscriber
            $array = array();
            foreach ((array) $data->subscriber as $value):
                if (!is_array($value)):
                    $array[] = $value;
                endif;
            endforeach;
            $data->subscriber = implode(',', $array);
        }

        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param	integer	The id of the primary key.
     *
     * @return	mixed	Object on success, false on failure.
     * @since	1.6
     */
    public function getItem($pk = null) {
        if ($item = parent::getItem($pk)) {

            //Do any procesing on fields here if needed
        }

        return $item;
    }

    /**
     * Prepare and sanitise the table prior to saving.
     *
     * @since	1.6
     */
    protected function prepareTable($table) {
        jimport('joomla.filter.output');

        if (empty($table->id)) {

            // Set ordering to the last item if not set
            if (@$table->ordering === '') {
                $db = JFactory::getDbo();
                $db->setQuery('SELECT MAX(ordering) FROM #__jdsubscriptions_subscriptions');
                $max = $db->loadResult();
                $table->ordering = $max + 1;
            }
        }
    }

    /**
     * Get the subscription details
     *
     * @since	1.6
     */
    public function getSubscription() {
        //Get a db connection.
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__jdsubscriptions_subscriptions');
        $query->where('id =' . JRequest::getVar('id'));

        $db->setQuery($query);

        //Get result
        $row = $db->loadObject();

        return $row;
    }

}