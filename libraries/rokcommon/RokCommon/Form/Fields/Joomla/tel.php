<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

RokCommon_Form_Helper::loadFieldClass('text');

/**
 * Form Field class for the Joomla Platform.
 * Supports a text field telephone numbers.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @link        http://www.w3.org/TR/html-markup/input.tel.html
 * @see         JFormRuleTel for telephone number validation
 * @see         JHtmlTel for rendering of telephone numbers
 * @since       11.1
 */
class RokCommon_Form_Field_Tel extends RokCommon_Form_Field_Text
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Tel';
}
