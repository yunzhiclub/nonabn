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

abstract class JdsubscriptionsToolbarHelper {

    public static $isJ30 = null;

    public static function addToolbar($view = '') {
        $user = JFactory::getUser();

        // load language file (.sys because the toolbar has the same options as the components dropdown)
        JFactory::getLanguage()->load('com_jdsubscriptions.sys', JPATH_ADMINISTRATOR);

        // add toolbar entries
        // overview

        /* //Add to sidemenu if needed
          self::addEntry('MANAGE_FORMS', 'index.php?option=com_rsform&view=forms', $view == 'forms');
          self::addEntry('MANAGE_SUBMISSIONS', 'index.php?option=com_rsform&view=submissions', $view == 'submissions');
          self::addEntry('CONFIGURATION', 'index.php?option=com_rsform&view=configuration', $view == 'configuration');
          self::addEntry('BACKUP_RESTORE', 'index.php?option=com_rsform&view=backuprestore', $view == 'backuprestore');
          self::addEntry('UPDATES', 'index.php?option=com_rsform&view=updates', $view == 'updates');
          self::addEntry('PLUGINS', 'index.php?option=com_rsform&task=goto.plugins', false);
         */
    }

    protected static function addEntry($lang_key, $url, $default = false) {
        $lang_key = 'COM_JDSUBSCRIPTIONS_' . $lang_key;

        if (self::$isJ30) {
            JHtmlSidebar::addEntry(JText::_($lang_key), JRoute::_($url), $default);
        } else {
            JSubMenuHelper::addEntry(JText::_($lang_key), JRoute::_($url), $default);
        }
    }

    public static function addFilter($text, $key, $options) {
        if (self::$isJ30) {
            JHtmlSidebar::addFilter($text, $key, $options);
        }

        // nothing for 2.5
    }

    public static function render() {
        if (self::$isJ30) {
            return JHtmlSidebar::render();
        } else {
            return '';
        }
    }

}

$jversion = new JVersion();
JdsubscriptionsToolbarHelper::$isJ30 = $jversion->isCompatible('3.0');