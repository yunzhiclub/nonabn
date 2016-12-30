CREATE TABLE IF NOT EXISTS `#__jdsubscriptions_plans` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(255)  NOT NULL ,
`description` TEXT NOT NULL ,
`subscription_image` VARCHAR(255)  NOT NULL ,
`duration` INT(11)  NOT NULL ,
`unit` VARCHAR(255)  NOT NULL ,
`price` VARCHAR(255)  NOT NULL ,
`recurring` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__jdsubscriptions_subscribers` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id` INT(11)  NOT NULL ,
`name` VARCHAR(255)  NOT NULL ,
`username` VARCHAR(255)  NOT NULL ,
`email` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__jdsubscriptions_orders` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`subscriber` int(11) NOT NULL,
`subscriber_email` varchar(255) NOT NULL,
`subscription_plan` int(11) NOT NULL,
`subscription_amount` varchar(255) NOT NULL,
`pp_transaction_id` VARCHAR(255)  NOT NULL ,
`order_date` int(255) NOT NULL,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__jdsubscriptions_subscriptions` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`subscription_plan` INT NOT NULL ,
`subscriber` INT NOT NULL ,
`status` varchar(255) NOT NULL DEFAULT 'active',
`start_date` INT(11)  NOT NULL ,
`end_date` INT(11)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

