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
    <?php foreach ($this->buttons as $button) { ?>
        <?php if ($button['access']) { ?>
            <div class="dashboard-info dashboard-button">
                <a href="<?php echo $button['link']; ?>"> 
                    <img src="<?php echo $button['image']; ?>" alt="<?php echo $button['text']; ?>" />
                    <span class="dashboard-title"><?php echo $button['text']; ?></span> 
                </a> 
            </div>
        <?php } ?>
    <?php } ?>
</div>
<span class="rsform_clear_both"></span>