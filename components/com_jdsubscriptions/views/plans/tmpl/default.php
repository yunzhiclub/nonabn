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
?>
<style>
    .subscriptions_thumb{
        width:140px;
    }
</style>
<script type="text/javascript">
    function deleteItem(item_id){
        if(confirm("<?php echo JText::_('COM_JDSUBSCRIPTIONS_DELETE_MESSAGE'); ?>")){
            document.getElementById('form-membership-delete-' + item_id).submit();
        }
    }
</script>
<?php $user = JFactory::getUser(); ?>
<div id="subscriptions">
    <h2>Available Subscriptions</h2>
    <?php if ($user->guest) : //If user is not logged in?>
        <p>You must <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">register</a> or login to purchase a subscription</p>
    <?php endif; ?>
    <ul class="subscriptions_list">
        <?php $show = false; ?>
        <?php foreach ($this->items as $item) : ?>
            <?php
            if ($item->subscription_image) {
                $image = $item->subscriptions_image;
            } else {
                $image = JURI::base() . 'media/com_jdsubscriptions/images/plan_image.png';
            }
            ?>
            <?php
            if ($item->state == 1 || ($item->state == 0 && JFactory::getUser()->authorise('core.edit.own', ' com_jdclassifieds'))):
                $show = true;
                ?>
                <li>    
                    <div class="subscriptions_left">
                        <img class="subscriptions_thumb" src="<?php echo $image; ?>" />
                    </div>
                    <div class="subscriptions_right">  
                            <h3><?php echo $item->name; ?></h3>
                        <?php echo $item->description; ?>
                        <ul class="specs">
                            <div class="spec_items">
                                <li><strong>Duration:</strong> <?php echo $item->duration . ' ' . $item->unit; ?></li>
                                <li><strong>Price:</strong> <?php echo $item->price . ' ' . $this->params->get('currency', 'USD'); ?></li>
                                <li><strong>Recurring:</strong> <?php
                if ($item->recurring == 0) {
                    echo 'No';
                } else {
                    echo 'Yes';
                }
                        ?></li>

                            </div>

                            <div class="buynow">
                                <?php if (!$user->guest || $this->params->get('allow_guests',0) == 1) : //If user is logged in?>
                                    <a href="<?php echo JRoute::_('index.php?option=com_jdsubscriptions&view=plan&id=' . (int) $item->id); ?>">
                                        <img src="<?php echo JURI::base(); ?>media/com_jdsubscriptions/images/buynow.png" />
                                    </a>
                                <?php else : ?>
                                   <p class="login_purchase"><?php echo JText::_('COM_JDSUBSCRIPTIONS_LOGIN_PURCHASE'); ?></p>
                                <?php endif; ?>
                            </div>

                        </ul>

                    </div>
                </li>
                <div class="clr"></div>
            <?php endif; ?>

        <?php endforeach; ?>
        <?php
        if (!$show):
            echo JText::_('COM_JDSUBSCRIPTIONS_NO_ITEMS');
        endif;
        ?>
    </ul>
</div>
<?php if ($show): ?>
    <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>

