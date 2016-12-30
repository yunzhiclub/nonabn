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

/**
 * Jdsubscriptions helper.
 */
class JdsubscriptionsHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
                JHtmlSidebar::addEntry(
			JText::_('COM_JDSUBSCRIPTIONS_TITLE_CPANEL'),
			'index.php?option=com_jdsubscriptions&view=cpanel',
			$vName == 'cpanel'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_JDSUBSCRIPTIONS_TITLE_PLANS'),
			'index.php?option=com_jdsubscriptions&view=plans',
			$vName == 'plans'
		);
                JHtmlSidebar::addEntry(
			JText::_('COM_JDSUBSCRIPTIONS_TITLE_SUBSCRIPTIONS'),
			'index.php?option=com_jdsubscriptions&view=subscriptions',
			$vName == 'subscriptions'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_JDSUBSCRIPTIONS_TITLE_SUBSCRIBERS'),
			'index.php?option=com_jdsubscriptions&view=subscribers',
			$vName == 'subscribers'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_JDSUBSCRIPTIONS_TITLE_ORDERS'),
			'index.php?option=com_jdsubscriptions&view=orders',
			$vName == 'orders'
		);


	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_jdsubscriptions';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
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
            } elseif ($result->start_date < $result->end_date && $result->status == 'active') {
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
}
