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

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_jdsubscription', JPATH_ADMINISTRATOR);
//Get image
if (isset($item->subscription_image)) {
    $image = $this->item->subscription_image;
} else {
    $image = JURI::base() . 'media/com_jdsubscriptions/images/plan_image.png';
}
$app = JFactory::getApplication();
$user = JFactory::getUser();
$return_url = JRoute::_(JURI::base() . 'index.php?option=com_jdsubscriptions&view=process&status=success');
$cancel_return_url = JRoute::_(JURI::base() . 'index.php?option=com_jdsubscriptions&view=process&status=cancel');
?>

<?php if ($this->item) : ?>
    <div id="subscription">
        <h2><?php echo $this->item->name; ?></h2>
        <div class="subscription_img">
            <img src="<?php echo $image; ?>" alt="<?php echo $this->item->name; ?>" />
        </div>
        <div class="subscription_specs">
            <h4><?php echo JText::_('COM_JDSUBSCRIPTIONS_FORM_LBL_SUBSCRIPTION_SPECIFICS'); ?></h4>
            <ul>                           
                <li><?php echo JText::_('COM_JDSUBSCRIPTIONS_FORM_LBL_SUBSCRIPTION_DURATION'); ?>:
                    <?php echo $this->item->duration . ' ' . $this->item->unit; ?></li>
                <li><?php echo JText::_('COM_JDSUBSCRIPTIONS_FORM_LBL_SUBSCRIPTION_PRICE'); ?>:
                    <?php echo $this->item->price; ?></li>      
                <li><?php echo JText::_('COM_JDSUBSCRIPTIONS_FORM_LBL_SUBSCRIPTION_RECURRING'); ?>:
                    <?php echo ($this->item->recurring ? 'Yes' : 'No'); ?>
                </li>    
            </ul>
        </div>
        <div class="clr"></div>
        <?php if ($this->item->description) : ?>
            <div class="subscription_description">
                <h3 class="subscription_description_heading"><?php echo JText::_('COM_JDSUBSCRIPTIONS_FORM_LBL_SUBSCRIPTION_DESCRIPTION'); ?></h3>
                <?php echo $this->item->description; ?>
            </div>
        <?php endif; ?>

    <?php if (!$user->guest || $this->params->get('allow_guests',0) == 1) : ?>
        <!--PAYPAL INFO-->
        <?php if ($this->item->recurring == 1) : ?>
            <!--Recurring Billing-->
            <form action="https://www.paypal.com/us/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick-subscriptions">
                <input type="hidden" name="business" value="<?php echo $this->params->get('paypal_email', 'techguyinfo@gmail.com'); ?>">
                <input type="hidden" name="item_name" value="<?php echo $app->getCfg('sitename') . ' - ' . $this->item->name; ?>">
                <input type="hidden" name="item_number" value="<?php echo $this->item->id; ?>">
                <input type="hidden" name="currency_code" value="<?php echo $this->params->get('currency', 'USD'); ?>">
                <input type="hidden" name="a3" value="<?php echo $this->item->price; ?>">
                <input type="hidden" name="p3" value="<?php echo $this->item->duration; ?>">
                <input type="hidden" name="t3" value="<?php
                //Get the unit and provide payPal field (letter)
                if ($this->item->unit == 'days') {
                    echo 'D';
                } elseif ($this->item->unit == 'weeks') {
                    echo 'W';
                } elseif ($this->item->unit == 'months') {
                    echo 'M';
                } elseif ($this->item->unit == 'years') {
                    echo 'Y';
                }
                ?>">
                <input type='hidden' name='no_shipping' value='1'>
                <input type="hidden" name="src" value="1">
                <input type="hidden" name="sra" value="1">
                <input type='hidden' name='rm' value='2'>
                <input type="hidden" name="return" value="<?php echo $return_url; ?>">
                <input type="hidden" name="cancel_return" value="<?php echo $cancel_return_url; ?>">
                <input type="image" src="<?php echo JURI::base(); ?>media/com_jdsubscriptions/images/paypal_subscribe_blue.png" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
            </form> 
        <?php else : ?>
            <!--One Time Billing-->
            <form action="https://www.paypal.com/us/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="<?php echo $this->params->get('paypal_email', 'techguyinfo@gmail.com'); ?>">
                <input type="hidden" name="item_name" value="<?php echo $app->getCfg('sitename') . ' - ' . $this->item->name; ?>">
                <input type="hidden" name="item_number" value="<?php echo $this->item->id; ?>">
                <input type="hidden" name="currency_code" value="<?php echo $this->params->get('currency', 'USD'); ?>">
                <input type="hidden" name="amount" value="<?php echo $this->item->price; ?>">
                <input type='hidden' name='no_shipping' value='1'>
                <input type='hidden' name='rm' value='2'>
                <input type="hidden" name="return" value="<?php echo $return_url; ?>">
                <input type="hidden" name="cancel_return" value="<?php echo $cancel_return_url; ?>">
                <input type="image" src="<?php echo JURI::base(); ?>media/com_jdsubscriptions/images/paypal_buy_blue.png" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
            </form> 
        <?php endif; ?>
    <?php else : ?>
        <p class="login_purchase"><?php echo JText::_('COM_JDSUBSCRIPTIONS_LOGIN_PURCHASE'); ?></p>
    <?php endif; ?>
    </div>
    <?php
else:
    echo JText::_('COM_JDSUBSCRIPTIONS_ITEM_NOT_LOADED');
endif;
?>
