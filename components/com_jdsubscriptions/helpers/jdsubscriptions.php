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

abstract class JdsubscriptionsHelper {

    public static function checkLogin($location,$msg,$type) {
        //Get application object
        $app = JFactory::getApplication();
        //Check if logged in
        $user = & JFactory::getUser();
        if ($user->guest) {
            //Redirect guests
            $app->redirect($location, JText::_($msg), $type);
        } else {
            return;
        }
    }
    
    /**
     * Checks for valid subscriptions and change status if needed
     *
     * @return	JObject
     * @since	1.6
     */
    public static function checkSubscriptions() {
        //Get application object
        $app = JFactory::getApplication();

        //Get a db connection.
        $db = JFactory::getDbo();

        //Create a new query object.
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__jdsubscriptions_subscriptions');

        //Reset the query using our newly populated query object.
        $db->setQuery($query);

        //Get results list
        $results = $db->loadObjectList();

        foreach ($results as $result) {
            if ($result->start_date > $result->end_date) {
                $db = & JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->update('#__jdsubscriptions_subscriptions');
                $query->set("status='expired'");
                $query->where('id' . '=' . $result->id);
                $db->setQuery($query);
                $db->query();
            } elseif ($result->start_date < $result->end_date) {
                $db = & JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->update('#__jdsubscriptions_subscriptions');
                $query->set("status='active'");
                $query->where('id' . '=' . $result->id);
                $db->setQuery($query);
                $db->query();
            }
        }
    }
    
     /**
     * Check canceled subscriptions
     *
     * @return	JObject
     * @since	1.6
     */
    public static function subscriptionCanceled($id) {
        //Get application object
        $app = JFactory::getApplication();

        //Get a db connection.
        $db = JFactory::getDbo();

        //Create a new query object.
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__jdsubscriptions_subscriptions');
        $query->where('id' . '=' . $id);
        $query->where("status='canceled'");
        //Reset the query using our newly populated query object.

        $db->setQuery($query);
        $db->query();
        $num_rows = $db->getNumRows();
        if($num_rows > 0){
            return true;
        } else {
            return false;
        }
    }

}

