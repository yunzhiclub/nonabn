<?php
/**
 * @version     1.0
 * @package     com_jdsubscriptions
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @author      Brad Traversy <support@joomdigi.com> - http://www.joomdigi.com
 * @get variables
 	status (success or cancel)
	tx (transaction number)
	st (completed)
	amt (amount)
	cc (curency code)
	item_number (membership id)
	item_id
 */
// no direct access
defined('_JEXEC') or die;
//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_jdsubscriptions', JPATH_ADMINISTRATOR);
$app = JFactory::getApplication();
?>
<?php if($app->input->get('status') == 'success') : ?>
	<h2>Success!</h2>
	<p>Your subscription is now active</p>
	<p><strong>Order Info:</strong></p>
	<ul class="order_list">
		<li><strong>Subscription:</strong> <?php echo $this->subscriptionplan->name; ?></li>
                 <h4>Subscription Dates</h4>
		<li><strong>Duration:</strong> <?php echo $this->subscriptionplan->duration.' '.$this->subscriptionplan->unit; ?></li>
                <li><strong>Start Date:</strong> <?php echo date("F j, Y, g:i a",$this->subscription->start_date); ?></li>
                <li><strong>End Date:</strong> <?php echo date("F j, Y, g:i a",$this->subscription->end_date); ?></li>
                <h4>Payment Info</h4>
                <li><strong>Price:</strong> <?php echo $this->subscriptionplan->price; ?></li>
		<li><strong>PayPal Transaction #:</strong> <?php echo $app->input->get('tx'); ?></li>
	</ul>	
	<br />
	
	<?php //print_r($_GET); ?><br />
	
<?php elseif($app->input->get('status') == 'cancel') : ?>
        <h2>Canceled</h2>
        <p>Your payment has been canceled</p>
<?php else : ?>
    <?php $app->redirect('index.php'); ?>
<?php endif; ?>
