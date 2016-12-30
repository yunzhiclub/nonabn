<?php
/**
 * @version     1.0
 * @package     com_jdsubscriptions
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @author      Brad Traversy <support@joomdigi.com> - http://www.joomdigi.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

//Require Helper
require_once JPATH_COMPONENT . '/helpers/jdsubscriptions.php';

/**
 * Methods supporting searching of Jdsubscriptions records.
 */
class JdsubscriptionsModelProcess extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.0
     */
    public function __construct($config = array()) {

        parent::__construct($config);

        //Get application object

        $app = JFactory::getApplication();



        //Check login and redirect

        JdsubscriptionsHelper::checkLogin('index.php', 'You are not logged in', 'error');



        //Get params

        $componentParams = $app->getParams('com_jdsubscriptions');



        $debug_mode = $componentParams->get('debug_mode', 0);



        if ($app->input->get('status') == 'success' && $app->input->get('st') == 'Completed') {

            //Add new subscription

            $this->addSubscription();

            if (!$debug_mode) {

                //Add the order if not in debug mode

                $this->addOrder();
            }

            //Add new subscriber

            $this->addSubscriber();
        } else {

            //Redirect to the cancel page

            $app->redirect('index.php?option=jdsubscriptions&view=process&status=cancel');
        }
    }

    /**
     * Get subscription plan info
     *
     * @param    none
     * @since    1.0
     */
    public function getSubscriptionPlan() {

        //Get application object

        $app = JFactory::getApplication();

        //Get params

        $componentParams = $app->getParams('com_jdsubscriptions');

        $debug_mode = $componentParams->get('debug_mode', 0);

        //Check debug mode

        if (!$debug_mode) {

            //Get subscription plan ID

            $plan_id = $app->input->get('item_number');
        } else {

            $plan_id = 1;
        }



        //Get a db connection.

        $db = JFactory::getDbo();



        //Create a new query object.

        $query = $db->getQuery(true);

        $query->select('*');

        $query->from('#__jdsubscriptions_plans as p');

        $query->where('p.id =' . $plan_id);



        //Reset the query using our newly populated query object.

        $db->setQuery($query);



        //Get results list

        $results = $db->loadObjectList();



        //Return the results

        return $results[0];
    }

    /**
     * Ad order to subscriptions table
     *
     * @param    none
     * @since    1.0
     */
    public function addSubscription() {

        //Get application object

        $app = JFactory::getApplication();

        //Get user object

        $user = JFactory::getUser();

        //User ID

        $user_id = $user->id;

        //User email

        $user_email = $user->email;

        //Get subscription ID

        $plan_id = $this->getSubscriptionPlan()->id;

        //Get subscription duration

        $duration = $this->getSubscriptionPlan()->duration;

        //Get subscription unit

        $unit = $this->getSubscriptionPlan()->unit;

        //Get order date

        $order_date = strtotime("now");

        //Get end date

        $end_date = $this->getEndDate($duration, $unit);

        // Get a db connection.

        $db = JFactory::getDbo();

        // Create a new query object.

        $query = $db->getQuery(true);

        if ($this->checkForSubscription() != 0) {

            //Renew subscription

            $query->update('#__jdsubscriptions_subscriptions');

            $query->set('start_date' . '=' . $db->quote($order_date));

            $query->set('end_date' . '=' . $db->quote($end_date));

            $query->where('subscription_plan' . '=' . $db->quote($plan_id));

            $query->where('subscriber' . '=' . $db->quote($user_id));

            $db->setQuery($query);

            $db->query();
        } else {

            $db = JFactory::getDbo();

            $query = $db->getQuery(true);

            $query->insert('#__jdsubscriptions_subscriptions');

            $query->set("

                subscriber=$user_id,

                subscription_plan = $plan_id,

                status='active',

                start_date = $order_date,

                end_date = $end_date,

                state = 1,

                created_by = $user_id

            ");



            $db->setQuery($query);

            $db->query();
        }
    }

    /**
     * Add subscriber
     *
     * @param    none
     * @since    1.0
     */
    public function addSubscriber() {

        if ($this->checkForSubscriber() == 0) {

            //Get user object

            $user = JFactory::getUser();

            //User ID

            $user_id = $user->id;

            //User email

            $user_email = $user->email;

            //User Name

            $name = $user->name;

            //User Username

            $username = $user->username;

            $db = JFactory::getDbo();

            $query = $db->getQuery(true);

            $query->insert('#__jdsubscriptions_subscribers');

            $query->set("

                user_id=$user_id, 

                email='$user_email',

                name = '$name',  

                username = '$username',   

                state = 1

            ");



            $db->setQuery($query);

            $db->query();
        }
    }

    /**
     * Check for existing subscription
     *
     * @param    none
     * @since    1.0
     */
    public function checkForSubscription() {

        //Get application object

        $app = JFactory::getApplication();

        //Get user object

        $user = JFactory::getUser();

        //User ID

        $user_id = $user->id;

        //User email

        $user_email = $user->email;

        //Get subscription ID

        $plan_id = $this->getSubscriptionPlan()->id;



        //Get a db connection.

        $db = JFactory::getDbo();



        //Create a new query object.

        $query = $db->getQuery(true);



        $query->select('*');

        $query->from('#__jdsubscriptions_subscriptions');

        $query->where('subscriber' . '=' . $db->quote($user_id));



        //Reset the query using our newly populated query object.

        $db->setQuery($query);

        $db->query();

        $num_rows = $db->getNumRows();

        return $num_rows;
    }

    /**
     * Check for existing subscriber
     *
     * @param    none
     * @since    1.0
     */
    public function checkForSubscriber() {

        //Get user object

        $user = JFactory::getUser();

        //User ID

        $user_id = $user->id;



        //Get a db connection.

        $db = JFactory::getDbo();



        //Create a new query object.

        $query = $db->getQuery(true);



        $query->select('*');

        $query->from('#__jdsubscriptions_subscribers');

        $query->where('user_id' . '=' . $db->quote($user_id));



        //Reset the query using our newly populated query object.

        $db->setQuery($query);

        $db->query();

        $num_rows = $db->getNumRows();

        return $num_rows;
    }

    /**
     * Ad order to orders table
     *
     * @param    none
     * @since    1.0
     */
    public function addOrder() {

        //Get application object

        $app = JFactory::getApplication();

        //Get user object

        $user = JFactory::getUser();

        //User ID

        $user_id = $user->id;

        //User email

        $user_email = $user->email;

        //User email

        $user_name = $user->name;

        //Get subscription ID

        $plan_id = $this->getSubscriptionPlan()->id;

        //Get subscription duration

        $duration = $this->getSubscriptionPlan()->duration;

        //Get subscription unit

        $unit = $this->getSubscriptionPlan()->unit;

        //Get subscription price

        $price = $this->getSubscriptionPlan()->price;

        //Get PayPal Trans ID

        $pp_transaction_id = $app->input->get('tx');

        //Get order date

        $order_date = strtotime("now");

        //Get end date

        $end_date = $this->getEndDate($duration, $unit);

        // Get a db connection.

        $db = JFactory::getDbo();

        // Create a new query object.

        $query = $db->getQuery(true);

        //Get database object

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->insert('#__jdsubscriptions_orders');

        $query->set("

                subscriber=$user_id, 

                subscriber_email='$user_email',

                subscription_plan = $plan_id,

                subscription_amount = $price,

                pp_transaction_id = '$pp_transaction_id',

                order_date = $order_date,

                state = 1,

                created_by = $user_id

            ");



        $db->setQuery($query);

        $db->query();
    }

    /**
     * Get the subscriptions end date
     *
     * @param    none
     * @since    1.0
     */
    public function getEndDate($duration, $unit) {

        $order_date = strtotime("now");

        $end_date = strtotime("+" . $duration . " " . $unit, $order_date);

        return $end_date;
    }

    /**
     * Get subscription
     *
     * @param    none
     * @since    1.0
     */
    public function getSubscription() {

        //Get application object

        $app = JFactory::getApplication();

        //Get subscription plan ID
        //$plan_id = $app->input->get('item_number');

        $plan_id = 1;

        //Get user object

        $user = JFactory::getUser();

        //User ID

        $user_id = $user->id;

        //Get a db connection.

        $db = JFactory::getDbo();

        //Create a new query object.

        $query = $db->getQuery(true);

        $query->select('*');

        $query->from('#__jdsubscriptions_subscriptions');

        $query->where('subscriber' . '=' . $db->quote($user_id));

        $query->where('subscription_plan' . '=' . $db->quote($plan_id));



        //Reset the query using our newly populated query object.

        $db->setQuery($query);



        //Get results list

        $row = $db->loadObject();



        //Return the results

        return $row;
    }

}

