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
 * Methods for control panel
 */
class JdsubscriptionsModelcpanel extends JModelList {

    public function getButtons() {

        /* $button = array(
          'access', 'id', 'link', 'target', 'onclick', 'title', 'image', 'alt', 'text'
          ); */

          $buttons = array(
            array(
                'link' => JRoute::_('index.php?option=com_jdsubscriptions&view=plans'),
                'image' => 'components/com_jdsubscriptions/assets/images/l_plans.png',
                'text' => JText::_('COM_JDSUBSCRIPTIONS_CPANEL_PLANS'),
                'access' => true
            ),
            array(
                'link' => JRoute::_('index.php?option=com_jdsubscriptions&view=subscriptions'),
                'image' => 'components/com_jdsubscriptions/assets/images/l_subscriptions.png',
                'text' => JText::_('COM_JDSUBSCRIPTIONS_CPANEL_SUBSCRIPTIONS'),
                'access' => true
            ),
            array(
                'link' => JRoute::_('index.php?option=com_jdsubscriptions&view=subscribers'),
                'image' => 'components/com_jdsubscriptions/assets/images/l_subscribers.png',
                'text' => JText::_('COM_JDSUBSCRIPTIONS_CPANEL_SUBSCRIBERS'),
                'access' => true
            ),
            array(
                'link' => JRoute::_('index.php?option=com_jdsubscriptions&view=orders'),
                'image' => 'components/com_jdsubscriptions/assets/images/l_orders.png',
                'text' => JText::_('COM_JDSUBSCRIPTIONS_CPANEL_ORDERS'),
                'access' => true
            )
        );

        return $buttons;
    }
    
    function getVersion(){
        return '1.0.5';
    }

}
