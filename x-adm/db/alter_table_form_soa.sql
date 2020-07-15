ALTER TABLE `form_soa` ADD `date_of_paid` DATE NULL AFTER `id_status`;
ALTER TABLE `form_soa` ADD `spending_amount` DOUBLE NOT NULL DEFAULT '0' AFTER `date_of_paid`;