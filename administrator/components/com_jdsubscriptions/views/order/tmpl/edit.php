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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jdsubscriptions/assets/css/jdsubscriptions.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function(){
        
    });
    
    Joomla.submitbutton = function(task)
    {
        if(task == 'order.cancel'){
            Joomla.submitform(task, document.getElementById('order-form'));
        }
        else{
            
            if (task != 'order.cancel' && document.formvalidator.isValid(document.id('order-form'))) {
                
                Joomla.submitform(task, document.getElementById('order-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_jdsubscriptions&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="order-form" class="form-validate">
    <div class="row-fluid">
        <div class="span10 form-horizontal">
            <fieldset class="adminform">

                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('id'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('subscriber'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('subscriber'); ?></div>
                </div>
                  <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('subscriber_email'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('subscriber_email'); ?></div>
                </div>
                  <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('subscription_plan'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('subscription_plan'); ?></div>
                </div>
                  <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('order_date'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('order_date'); ?></div>
                </div>
                  <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('subscription_amount'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('subscription_amount'); ?></div>
                </div>
                  <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('pp_transaction_id'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('pp_transaction_id'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('state'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
                </div>


            </fieldset>
        </div>



        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>