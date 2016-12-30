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
<?php $model = $this->getModel(); //Instantiate model  ?>

<div id="mysubscriptions">
    <h2><?php echo JText::_('COM_JDSUBSCRIPTIONS_MYSUBSCRIPTIONS_HEADING'); ?></h2>
    <p><?php echo JText::_('COM_JDSUBSCRIPTIONS_MYSUBSCRIPTIONS_TEXT'); ?></p>
    <?php if ($this->items) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Subscription</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
            <?php foreach ($this->items as $item) : ?>
            <?php $subscription_id = $model->getSubscriptionId($item->subscription_plan,$item->subscriber); ?>
            <tr>
                <td><?php echo $subscription_id; ?></td>
                <td><?php echo $item->name; ?></td>
                 <td><?php echo $item->duration; ?> <?php echo $item->unit; ?></td>
                 <td>
                     <?php if($item->status == 'active') : ?>
                        <div style="color:green;"><?php echo $item->status; ?></div>
                     <?php else : ?>
                        <div style="color:red;"><?php echo $item->status; ?></div> 
                     <?php endif; ?>
                 </td>
                 <td><a href="index.php?option=com_jdsubscriptions&view=mysubscription&id=<?php echo $subscription_id; ?>">Get Details</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <?php echo JText::_('COM_JDSUBSCRIPTIONS_MYSUBSCRIPTIONS_NO_ACTIVE'); ?>
		<br /><br />
		<a href="index.php?option=com_jdsubscriptions&view=plans">Buy a Subscription</a>
    <?php endif; ?>
</div>

