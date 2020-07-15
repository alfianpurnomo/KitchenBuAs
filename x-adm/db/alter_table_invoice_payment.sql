ALTER TABLE `invoice_payment` ADD `id_form_bd` INT NOT NULL DEFAULT '0' AFTER `id_invoice_payment`;
ALTER TABLE `invoice_payment` ADD `part_percentage` DOUBLE NOT NULL DEFAULT '0' AFTER `spending_amount`;

ALTER TABLE `invoice_payment` ADD `payment_by` SMALLINT(1) NOT NULL DEFAULT '1' COMMENT '1:trasfer;2:check/giro;3:cash' AFTER `date_of_paid`;
ALTER TABLE `invoice_payment` ADD `attr_payment` VARCHAR(225) NULL AFTER `payment_by`;

ALTER TABLE `invoice_payment` ADD `type` SMALLINT(1) NOT NULL DEFAULT '1' COMMENT '1:non_ppn;2:ppn' AFTER `attr_payment`;