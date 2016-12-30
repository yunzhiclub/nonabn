ALTER TABLE #__jdsubscriptions_orders
ADD COLUMN `subscriber_id` int(11) NOT NULL,
ADD COLUMN `subscriber_name` varchar(255) NOT NULL,
ADD COLUMN `subscription_plan` int(11) NOT NULL,
ADD COLUMN `subscription_amount` varchar(255) NOT NULL,
ADD COLUMN `order_date` int(255) NOT NULL;

ALTER TABLE #__jdsubscriptions_subscriptions
ADD COLUMN `subscriber_email` VARCHAR( 255 ) NOT NULL,
ADD COLUMN `is_active` TINYINT( 1 ) NOT NULL DEFAULT'1';