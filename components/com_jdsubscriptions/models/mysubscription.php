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
 * Methods for my subscription
 */
class JdsubscriptionsModelMysubscription extends JModelList {

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
        
        //Het user object
        $user = JFactory::getUser();
        
        //Get subscription info
        $this->getSubscription();
        
        //Check for cancel get variable
        if($app->input->get('cancel') == 1 ){
            $user = JFactory::getUser();
            $user_id = $user->id;
            $subscription_id = $this->getSubscription()->id;
            $this->cancelSubscription($user_id,$subscription_id);
        }
    }

   /**
     * Get subscription and order info
     *
     * @param    none
     * @since    2.0
     */
    public function getSubscription() {
        //Get application object
        $app = JFactory::getApplication();
        //Get database object
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('`#__jdsubscriptions_subscriptions` as a');
        $query->leftjoin('`#__jdsubscriptions_plans` AS b ON a.subscription_plan = b.id');
        $query->where('a.id =' . $app->input->get('id'));
        //Show published only
        $query->where('a.state = 1');
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        //echo $query;die();
        // Load the results as a list of stdClass objects.
        $row = $db->loadObject();
        return $row;
    }
    
    
     /**
     * Get order
     *
     * @param    none
     * @since    2.0
     */
    public function getPaypal($user_id,$plan_id) {
        //Get application object
        $app = JFactory::getApplication();
       
        //Get database object
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        $query->select('a.pp_transaction_id');
        $query->from('`#__jdsubscriptions_orders` as a');
        $query->where('a.subscriber =' . $user_id);
        $query->where('a.subscription_plan =' . $plan_id);
        //Show published only
        $query->where('a.state = 1');
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        //echo $query;die();
        // Load the results as a list of stdClass objects.
        $row = $db->loadObject();
        return $row->pp_transaction_id;
    }

    /**
     * Get the last day of the active subscription
     *
     * @param    none
     * @since    2.0
     */
    public function getEndDate($duration, $unit) {
        $order_date = strtotime("now");
        $end_date = strtotime("+" . $duration . " " . $unit, $order_date);
        return $end_date;
    }

    /**
     * Get the days left
     *
     * @param    none
     * @since    2.0
     */
    public function getDaysleft() {
        $now = strtotime("now");
        @$endDate = $this->getSubscription()->end_date;
        $difference = ($endDate - $now);
        if (floor($difference / 86400) < 10) {
            return '<span style="color:red">' . floor($difference / 86400) . ' days ' . floor(($difference % 86400) / 3600) . ' hours ' . floor((($difference %
                            86400) % 3600) / 60) . ' minutes ' . (((($difference % 86400) % 3600) % 60)) . ' seconds</span>.';
        } else {
            return '<span style="color:green">' . floor($difference / 86400) . ' days ' . floor(($difference % 86400) / 3600) . ' hours ' . floor((($difference %
                            86400) % 3600) / 60) . ' minutes ' . (((($difference % 86400) % 3600) % 60)) . ' seconds</span>.';
        }
    }

    /**
     * Cancel subscription
     *
     * @param    none
     * @since    2.0
     */
    public function cancelSubscription($user_id,$subscription_id){
        $db = & JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->update('#__jdsubscriptions_subscriptions');
        $query->set("status = 'canceled'");
        $query->where('id' . '=' . $subscription_id);
        $query->where('subscriber' . '=' . $user_id);
     
        $db->setQuery($query);
        $db->query();

        //Get application object
        $app = JFactory::getApplication();
        $app->redirect('index.php?option=com_jdsubscriptions&view=mysubscriptions', 'Your subscription has been canceled');
    }
    
     /**
     * Get subscriber info
     *
     * @param    none
     * @since    2.0
     */
    public function getSubscriber() {
        //Get application object
        $app = JFactory::getApplication();
        //Get user object
        $user = JFactory::getUser();
        //Get database object
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('`#__jdsubscriptions_subscribers` as a');
        $query->where('a.user_id =' . $user->id);
        //Show published only
        $query->where('a.state = 1');
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        //echo $query;die();
        // Load the results as a list of stdClass objects.
        $row = $db->loadObject();
        return $row;
    }

}