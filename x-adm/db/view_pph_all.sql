CREATE OR REPLACE VIEW `view_pph_all` AS 
(SELECT  f.bd_number
					,h.category_name as prefix_vendor
					,g.address as address
					,g.address_npwp as address_npwp
					,g.npwp
					,g.name
					,b.name as item_name
					,a.id_form_bd_item_pph
					,a.id_sub_tax as sub_tax,
					(case when (`i`.`id_tax` = '1') then ((a.percentage/100) * b.real_amount * round(c.part_percentage,2) *e.value) else 0 end) AS `pph_23`,
					(case when (`i`.`id_tax` = '2') then ((a.percentage/100) * b.real_amount * round(c.part_percentage,2) *e.value) else 0 end) AS `pph_26`,
					(case when (`i`.`id_tax` = '3') then ((a.percentage/100) * b.real_amount * round(c.part_percentage,2) *e.value) else 0 end) AS `pph_4`,
					(case when (`i`.`id_tax` = '5') then ((a.percentage/100) * b.real_amount * round(c.part_percentage,2) *e.value) else 0 end) AS `pph_21`
					,a.percentage
					,b.id_form_bd
					,c.date_of_paid as date_payment_by_finance
					,c.curs_finance
					,c.part_percentage
					,b.real_amount
					,b.id_form_bd_item
					,b.id_currency
					,( (a.percentage/100) * b.real_amount * c.part_percentage *e.value ) as amount_part 
					, e.value as valid_curs
					,( (a.percentage/100) * b.real_amount * c.part_percentage  )  as real_amount_part
					,i.name as wht_code
			FROM form_bd_item_pph a  
			left join form_bd_item b on a.id_form_bd_item=b.id_form_bd_item
			left join  invoice_payment c on b.id_form_bd=c.id_form_bd
			join currency d on b.id_currency=d.id_currency
			join currency_value e on e.id_currency=d.id_currency
			join form_bd f on f.id_form_bd=b.id_form_bd
			left join vendor g on g.id_vendor=b.id_vendor
			join vendor_category h on h.id_vendor_category=g.id_category_vendor
			join sub_tax i on i.id_sub_tax=a.id_sub_tax
			WHERE e.valid_date = c.date_of_paid and f.is_delete=0 and a.is_delete = 0 and f.id_status = 1 and c.type=1)
union all(
SELECT  f.bd_number
					,(select category_name from vendor_category where id_vendor_category = (select id_category_vendor from vendor where id_vendor = (select id_vendor from form_bd_item where id_form_bd=b.id_form_bd and is_delete=0) )) as prefix_vendor
					,(select address from vendor where id_vendor = (select id_vendor from form_bd_item where id_form_bd=b.id_form_bd and is_delete=0)) as  address
					,(select address_npwp from vendor where id_vendor = (select id_vendor from form_bd_item where id_form_bd=b.id_form_bd and is_delete=0)) as  address_npwp
					,(select npwp from vendor where id_vendor = (select id_vendor from form_bd_item where id_form_bd=b.id_form_bd and is_delete=0)) as npwp
					,(select name from vendor where id_vendor = (select id_vendor from form_bd_item where id_form_bd=b.id_form_bd and is_delete=0)) as name
					,b.name as item_name
					,a.id_form_soa_item_pph
					,a.id_sub_tax as sub_tax,
					(case when (`i`.`id_tax` = '1') then ((a.percentage/100) * b.real_amount * round(c.part_percentage,2) *e.value) else 0 end) AS `pph_23`,
					(case when (`i`.`id_tax` = '2') then ((a.percentage/100) * b.real_amount * round(c.part_percentage,2) *e.value) else 0 end) AS `pph_26`,
					(case when (`i`.`id_tax` = '3') then ((a.percentage/100) * b.real_amount * round(c.part_percentage,2) *e.value) else 0 end) AS `pph_4`,
					(case when (`i`.`id_tax` = '5') then ((a.percentage/100) * b.real_amount * round(c.part_percentage,2) *e.value) else 0 end) AS `pph_21`
					,a.percentage
					,b.id_form_bd
					,c.date_of_paid as date_payment_by_finance
					,c.curs_finance
					,c.part_percentage
					,b.real_amount
					,b.id_form_soa_item
					,b.id_currency
					,( (a.percentage/100) * b.real_amount * c.part_percentage *e.value ) as amount_part 
					, e.value as valid_curs
					,( (a.percentage/100) * b.real_amount * c.part_percentage  )  as real_amount_part
					,i.name as wht_code
			FROM form_soa_item_pph a  
			left join form_soa_item b on a.id_form_soa_item=b.id_form_soa_item
			left join  invoice_payment c on b.id_form_bd=c.id_form_bd
			join currency d on b.id_currency=d.id_currency
			join currency_value e on e.id_currency=d.id_currency
			join form_bd f on f.id_form_bd=b.id_form_bd
			join sub_tax i on i.id_sub_tax=a.id_sub_tax
			WHERE e.valid_date = c.date_of_paid and f.is_delete=0 and a.is_delete = 0 and f.id_status = 1 and c.type=1
);
