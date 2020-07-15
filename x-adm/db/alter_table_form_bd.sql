ALTER TABLE `form_bd` ADD `id_status` INT NOT NULL DEFAULT '2' COMMENT '1:paid;2:unpaid' AFTER `is_delete`;

ALTER TABLE `form_bd` ADD `submit_to_finance` DATE NULL AFTER `request_date`;
ALTER TABLE `form_bd` ADD `verify_by_finance` DATE NULL AFTER `submit_to_finance`;
ALTER TABLE `form_bd` ADD `verify_by_tax` DATE NULL AFTER `verify_by_finance`;
ALTER TABLE `form_bd` ADD `id_divisi` INT NOT NULL AFTER `bd_number`;
ALTER TABLE `form_bd` ADD `id_cost_center` INT NOT NULL AFTER `id_divisi`;
ALTER TABLE `form_bd` ADD `date_of_promise` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `due_date`;