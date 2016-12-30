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

<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span>Subscription Info</span></a></li>
        <li><a href="#fragment-2"><span>Subscription Dates</span></a></li>
        <li><a href="#fragment-3"><span>Order Info</span></a></li>
        <li><a href="#fragment-4"><span>Subscriber Info</span></a></li>
    </ul>
    <div id="fragment-1">
        <h4>Subscription Info</h4>
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
    <div id="fragment-2">
        <h4>Subscription Dates</h4>
        <ul class="order_list">
            <li><strong>Duration:</strong> <?php echo $this->subscription->duration . ' ' . $this->subscription->unit; ?></li>
            <li><strong>Start Date:</strong> <?php echo date("F j, Y, g:i a", $this->subscription->start_date); ?></li>
            <li><strong>End Date:</strong> <?php echo date("F j, Y, g:i a", $this->subscription->end_date); ?></li>
            <li><strong>Days Left:</strong> <?php echo $model->getDaysLeft($app->input->get('id')); ?></li>
        </ul>  
    </div>
    <div id="fragment-3">
        <h4>Order Info</h4>
        <ul class="order_list">
            <li><strong>Price:</strong> <?php echo $this->subscription->price; ?></li>
            <li><strong>PayPal Transaction #:</strong> <?php echo $model->getPaypal($this->subscription->subscriber, $this->subscription->subscription_plan); ?></li>
        </ul>  
    </div>
    <div id="fragment-4">
        <h4>Subscriber Info</h4>
        <ul class="order_list">
            <li><strong>Name:</strong> <?php echo $this->subscriber->name; ?></li>
            <li><strong>Username:</strong> <?php echo $this->subscriber->username; ?></li>
            <li><strong>Email:</strong> <?php echo $this->subscriber->email; ?></li>
        </ul>
    </div>
    
</div>
<script>
    $( "#tabs" ).tabs();
</script>
