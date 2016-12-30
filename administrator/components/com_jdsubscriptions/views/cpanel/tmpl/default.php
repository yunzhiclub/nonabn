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

JHtml::_('behavior.tooltip');
JHTML::_('script', 'system/multiselect.js', false, true);
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jdsubscriptions/assets/css/jdsubscriptions.css');
$document->addStyleSheet('components/com_jdsubscriptions/assets/css/dashboard.css');

$user = JFactory::getUser();
$userId = $user->get('id');
?>

<form action="index.php" method="post" name="adminForm">
    <div class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div class="span10">
        <div id="dashboard-left">
            <?php echo $this->loadTemplate('buttons'); ?>
        </div>
        <div id="dashboard-right" class="hidden-phone hidden-tablet">
            <?php echo $this->loadTemplate('sidebar'); ?>
        </div>
    </div>	
    <input type="hidden" name="option" value="com_jdsubscriptions" />
    <input type="hidden" name="task" value="" />
</form>