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

//Instantiate model
$model = $this->getModel();
//Get app object
$app = JFactory::getApplication();
?> 
 <?php echo $model->getDaysLeft($app->input->get('id')); ?>
<div id="accordion">

  <h3>Subscription Info</h3>
  <div>
      <h4>Subscription Information</h4>
    <ul class="order_list">
            <li><strong>Subscription Name:</strong> <?php echo $this->subscription->name; ?></li>
            <li><strong>Subscription ID:</strong> <?php echo $app->input->get('id'); ?>
            <li><strong>Current Status:</strong> 
                <?php if($this->subscription->status == 'active') : ?>
                <apan class="active"><?php echo $this->subscription->status; ?></span>
                <?php else : ?>
                <span class="not-active"><?php echo ucwords($this->subscription->status); ?></span>
                <?php endif; ?>
            </li>
        </ul>
  </div>
  <h3>Subscription Dates</h3>
  <div>
      <h4>Subscription Date Information</h4>
    <ul class="order_list">
            <li><strong>Duration:</strong> <?php echo $this->subscription->duration . ' ' . $this->subscription->unit; ?></li>
            <li><strong>Start Date:</strong> <?php echo date("F j, Y, g:i a", $this->subscription->start_date); ?></li>
            <li><strong>End Date:</strong> <?php echo date("F j, Y, g:i a", $this->subscription->end_date); ?></li>
            <li><strong>Days Left:</strong> <?php echo $model->getDaysLeft($app->input->get('id')); ?></li>
        </ul>  
  </div>
  <h3>Order Info</h3>
  <div>
      <h4>Order & Payment Informarion</h4>
   <ul class="order_list">
            <li><strong>Price:</strong> <?php echo $this->subscription->price; ?></li>
            <li><strong>PayPal Transaction #:</strong> <?php echo $model->getPaypal($this->subscription->subscriber, $this->subscription->subscription_plan); ?></li>
        </ul>  
  </div>
   <h3>Subscriber Info</h3>
  <div>
      <h4>Subscriber Information</h4>
   <ul class="order_list">
    <li><strong>Name:</strong> <?php echo $this->subscriber->name; ?></li>
    <li><strong>Username:</strong> <?php echo $this->subscriber->username; ?></li>
    <li><strong>Email:</strong> <?php echo $this->subscriber->email; ?></li>
</ul>
  </div>
</div>
 
<script>
$( "#accordion" ).accordion();
</script>
