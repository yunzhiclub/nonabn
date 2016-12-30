<?php
/**
 * Core Design Access Text plugin for Joomla! 2.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla
 * @subpackage	Content
 * @category   	Plugin
 * @version		2.5.x.2.0.2
 * @copyright	Copyright (C) 2007 - 2012 Great Joomla!, http://www.greatjoomla.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL 3
 * 
 * This file is part of Great Joomla! extension.   
 * This extension is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

// no direct access
defined('_JEXEC') or die;

// Import library dependencies
jimport('joomla.plugin.plugin');

class plgContentCdAccessText extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.5
	 */
	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		// define language
		$this->loadLanguage();
	}

    /**
     * Call onContentPrepare function
     * Method is called by the view.
	 *
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	object	The content object.  Note $article->text is also available
	 * @param	object	The content params
	 * @param	int		The 'page' number
	 * @since	1.6
	 */
	function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		// define the regular expression for the bot
		$regex = "#{accesstext(?:\s?(.*?)?)?}(.*?){/accesstext}#is";

		// Explication:
		// $match[1]	-> match to the next processing
		// $match[2]	-> html text for authorized user

		if (!preg_match($regex, $article->text)) return false;

		// replacement {accesstext...} {/accesstext}
		$article->text = preg_replace_callback($regex, array($this, 'replacer'), $article->text);
	}

	/**
	 * Replacer
	 * 
	 * @return string
	 */

	function replacer(&$match)
	{
		$user = JFactory::getUser();

		// mode
		$set_mode = $this->params->get('set_mode', 'user');
		
		// disable for super administrator and administrator accounts 
		$disable = ( $this->params->get('disable', 'yes') == 'yes' ? true : false );
		$disable = $this->disableDefault($disable);

		if (isset($match[1]))
		{
			$set = ($match[1] ? $match[1] : '');
		} else
		{
			return false;
		}

		$get_html = ( isset($match[2]) ? trim($match[2]) : '' );
		$get_html = explode('||', $get_html);

		switch(sizeof($get_html)) {
			case 2:
				$get_noaccess = ( isset($get_html) ? $get_html[0] : '' ); // set no-access message
				$get_html = ( isset($get_html) ? $get_html[1] : '' ); // set "secret" message
				break;
			default:
				$get_noaccess = '';
				$get_html = ( isset($get_html) ? $get_html[0] : '' ); // set "secret" message
				break;
		}

		// set mode
		if (preg_match('#mode\s?=\s?"(user|level|facl)"#', $set, $get_mode))
		{

			$get_mode = ( isset($get_mode) ? $get_mode[1] : $set_mode );

		} else
		{
			$get_mode = $set_mode;
		}
		// end

		// set $message to empty
		$message = '';

		switch ($get_mode)
		{
			case 'user':

				// set users
				if (preg_match('#user\s?=\s?"(.+?)"#', $set, $get_user))
				{
					$get_user = ( isset($get_user) ? $get_user[1] : '' );
				} else
				{
					JError::raiseNotice('', JText::_('PLG_CONTENT_CDACCESSTEXT_NO_USER'));
					return false;
				}
				// end

				$user_name = (string) $user->get('username', '');
				
				$get_user_array = explode(':', $get_user);
				
				if ($user_name and in_array($user_name, $get_user_array) or $disable)
				{
					$message = $get_html;
					unset($get_html, $get_user_array);
				} else
				{
					$message = $get_noaccess;
					unset($get_noaccess);
				}

				break;

			case 'level':
				
				// set level
				if (preg_match('#level\s?=\s?"(.+?)"#', $set, $get_level))
				{
					$get_level = ( isset($get_level) ? strtolower($get_level[1]) : '' );
				} else
				{
					JError::raiseNotice('', JText::_('PLG_CONTENT_CDACCESSTEXT_NO_LEVEL'));
					return false;
				}
				
				$get_level_array = explode(':', $get_level);
				
				$db	= JFactory::getDBO();

				// Build the base query.
				$query	= $db->getQuery(true);
				$query->select('title');
				$query->from($db->nameQuote('#__viewlevels'));
				$query->where($db->nameQuote('id') . ' IN(' . implode(',', $user->getAuthorisedViewLevels()) . ')');
	
				// Set the query for execution.
				$db->setQuery((string) $query);
				
				$result_array = (array) $db->loadResultArray();
				$result_array = array_map('strtolower', $result_array);
				
				if (array_intersect($result_array, $get_level_array) or $disable)
				{
					$message = $get_html;
					unset($get_html, $get_level_array);
				} else
				{
					$message = $get_noaccess;
					unset($get_noaccess);
				}

				break;
				
			default:
				return false;
				break;
		}

		return $message;
	}

	/**
	 * Disable plugin for super administrator accounts
	 * 
	 * @param 	boolean	$disable
	 * @return 	boolean
	 */
	function disableDefault($disable = true) {
		// super admin user
		if(JFactory::getUser()->authorise('core.admin')) {
			if ($disable) return true;
		} 
		return false;
	}
}