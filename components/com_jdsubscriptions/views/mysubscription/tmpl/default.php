<?php
/**
 * @version     1.0
 * @package     com_jdsubscriptions
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @author      Brad Traversy <support@joomdigi.com> - http://www.joomdigi.com
 */
// no direct access
defined('_JEXEC') or die;
//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_jdsubscriptions', JPATH_ADMINISTRATOR);
require_once JPATH_COMPONENT . '/helpers/jdsubscriptions.php';

//Instantiate model
$model = $this->getModel();
//Get app object
$app = JFactory::getApplication();
?>
<div id="mysubscription">
    <h2><?php echo $this->subscription->name; ?></h2>
    <p>Here are the details of this subscription</p>
    <?php if (JdsubscriptionsHelper::subscriptionCanceled($app->input->get('id'))) : ?>
        Time Left: 0 <span class="not-active">(Canceled)</span>
    <?php else : ?>
        Time Left: <?php echo $model->getDaysLeft($app->input->get('id')); ?>
    <?php endif; ?>
    <p>
        <a href="<?php echo JRoute::_('index.php?option=com_jdsubscriptions&view=plan&id=' . $this->subscription->subscription_plan); ?>">Renew This Subscription</a>   
         <?php if (!JdsubscriptionsHelper::subscriptionCanceled($app->input->get('id'))) : ?>
          |  <a  onclick="return confirm('Are you sure?')" href="<?php echo JRoute::_('index.php?option=com_jdsubscriptions&view=mysubscription&task=mysubscription.cancel&id=' . $app->input->get('id')); ?>">Cancel This Subscription</a> 
        <?php endif; ?>
    </p>
    <?php $layout = $this->params->get('mysubscription_layout', 'tabs'); ?>
    <?php echo $this->loadTemplate($layout); //Load template ?>
</div>
