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

jimport('joomla.application.component.view');

/**
 * View class for a list of Jdsubscriptions.
 */
class JdsubscriptionsViewSubscriptions extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		JdsubscriptionsHelper::addSubmenu('subscriptions');
        
		$this->addToolbar();
        
        $this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/jdsubscriptions.php';

		$state	= $this->get('State');
		$canDo	= JdsubscriptionsHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_JDSUBSCRIPTIONS_TITLE_SUBSCRIPTIONS'), 'subscriptions.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/subscription';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('subscription.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('subscription.edit','JTOOLBAR_EDIT');
		    }

        }

		if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('subscriptions.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('subscriptions.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'subscriptions.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('subscriptions.archive','JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('subscriptions.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'subscriptions.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::trash('subscriptions.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_jdsubscriptions');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_jdsubscriptions&view=subscriptions');
        
        $this->extra_sidebar = '';
                //Filter for the field ".subscription_plan;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_jdsubscriptions.subscription', 'subscription');

        $field = $form->getField('subscription_plan');

        $query = $form->getFieldAttribute('subscription_plan','query');
        $translate = $form->getFieldAttribute('subscription_plan','translate');
        $key = $form->getFieldAttribute('subscription_plan','key_field');
        $value = $form->getFieldAttribute('subscription_plan','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();
		/******************/

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            'Subscription Plan',
            'filter_subscription_plan',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.subscription_plan')),
            true
        );        //Filter for the field ".subscriber;
        jimport('joomla.form.form');
        $options = array();
        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        $form = JForm::getInstance('com_jdsubscriptions.subscription', 'subscription');

        $field = $form->getField('subscriber');

        //$query = $form->getFieldAttribute('subscriber','query');
        //$translate = $form->getFieldAttribute('subscriber','translate');
        //$key = $form->getFieldAttribute('subscriber','key_field');
        //$value = $form->getFieldAttribute('subscriber','value_field');

        // Get the database object.
        $db = JFactory::getDBO();

        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();

        // Build the field options.
        if (!empty($items))
        {
            foreach ($items as $item)
            {
                if ($translate == true)
                {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                }
                else
                {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }

        JHtmlSidebar::addFilter(
            'Subscriber',
            'filter_subscriber',
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.subscriber')),
            true
        );
		//Filter for the field status
		$select_label = JText::sprintf('COM_JDSUBSCRIPTIONS_FILTER_SELECT_LABEL', 'Status');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "active";
		$options[0]->text = "Active";
		$options[1] = new stdClass();
		$options[1]->value = "expired";
		$options[1]->text = "Expired";
		$options[2] = new stdClass();
		$options[2]->value = "cancelled";
		$options[2]->text = "Canceled";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_status',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.status'), true)
		);

		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

        
	}
    
	protected function getSortFields(){
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.subscription_plan' => JText::_('COM_JDSUBSCRIPTIONS_SUBSCRIPTIONS_SUBSCRIPTION_PLAN'),
		'a.subscriber' => JText::_('COM_JDSUBSCRIPTIONS_SUBSCRIPTIONS_SUBSCRIBER'),
		'a.status' => JText::_('COM_JDSUBSCRIPTIONS_SUBSCRIPTIONS_STATUS'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		'a.checked_out' => JText::_('COM_JDSUBSCRIPTIONS_SUBSCRIPTIONS_CHECKED_OUT'),
		'a.checked_out_time' => JText::_('COM_JDSUBSCRIPTIONS_SUBSCRIPTIONS_CHECKED_OUT_TIME'),
		'a.created_by' => JText::_('COM_JDSUBSCRIPTIONS_SUBSCRIPTIONS_CREATED_BY'),
		);
	}

    
}
