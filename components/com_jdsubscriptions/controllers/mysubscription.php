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

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Plans list controller class.
 */
class JdsubscriptionsControllerMysubscription extends JdsubscriptionsController {

    /**
     * Cancel a subscription.
     * @since	1.6
     */
    public function cancel() {
        $app = JFactory::getApplication();
        $subscription_id = $app->input->get('id');

        $model = $this->getModel('mysubscription');
        $user = JFactory::getUser();
        $user_id = $user->id;
        $model->cancelSubscription($user_id,$subscription_id);
    }

}
