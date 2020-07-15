ALTER TABLE `form_bd_item` ADD `account_name` VARCHAR(225) NULL AFTER `id_vendor`;
ALTER TABLE `form_bd_item` ADD `date_promise_settelment` DATE NULL AFTER `name`;
ALTER TABLE `form_bd_item` ADD `id_vendor_banking` INT NOT NULL AFTER `id_vendor`;
ALTER TABLE `form_bd_item` ADD `curs_ppn` DECIMAL NOT NULL DEFAULT '1' AFTER `id_status_pajak`;
ALTER TABLE `form_bd_item`
  DROP `account_name`,
  DROP `account_number`,
  DROP `bank_name`,
  DROP `date_promise_settelment`;