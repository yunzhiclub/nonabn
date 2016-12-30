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
<div class="dashboard-container">
	<div class="dashboard-info">
		<img src="components/com_jdsubscriptions/assets/images/brand.png" align="middle" alt="" />
		<table class="dashboard-table">
			<tr>
				<td nowrap="nowrap"><strong><?php echo JText::_('COM_JDSUBSCRIPTIONS_PRODUCT_VERSION') ?>: </strong></td>
				<td nowrap="nowrap">JD Classifieds <?php echo $this->version; ?></td>
			</tr>
			<tr>
				<td nowrap="nowrap"><strong><?php echo JText::_('COM_JDSUBSCRIPTIONS_COPYRIGHT') ?>: </strong></td>
				<td nowrap="nowrap">&copy; <?php echo gmdate('Y'); ?> <a href="http://www.joomDigi.com" target="_blank">JoomDigi</a></td>
			</tr>
			<tr>
				<td nowrap="nowrap"><strong><?php echo JText::_('COM_JDSUBSCRIPTIONS_LICENSE') ?>: </strong></td>
				<td nowrap="nowrap"><a href="http://www.gnu.org/licenses/gpl.html" target="_blank">GNU/GPL</a> Commercial</a></td>
			</tr>
			<tr>
				
			</tr>
		</table>
	</div>
</div>