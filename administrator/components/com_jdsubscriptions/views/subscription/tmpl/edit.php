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
        
	js('input:hidden.subscription_plan').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('subscription_planhidden')){
			js('#jform_subscription_plan option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_subscription_plan").trigger("liszt:updated");
	js('input:hidden.subscriber').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('subscriberhidden')){
			js('#jform_subscriber option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_subscriber").trigger("liszt:updated");
    });
    
    Joomla.submitbutton = function(task)
    {
        if(task == 'subscription.cancel'){
            Joomla.submitform(task, document.getElementById('subscription-form'));
        }
        else{
            
            if (task != 'subscription.cancel' && document.formvalidator.isValid(document.id('subscription-form'))) {
                
                Joomla.submitform(task, document.getElementById('subscription-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_jdsubscriptions&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="subscription-form" class="form-validate">
    <div class="row-fluid">
        <div class="span10 form-horizontal">
            <fieldset class="adminform">

                			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('subscription_plan'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('subscription_plan'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->subscription_plan as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="subscription_plan" name="jform[subscription_planhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('subscriber'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('subscriber'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->subscriber as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="subscriber" name="jform[subscriberhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('status'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('status'); ?></div>
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