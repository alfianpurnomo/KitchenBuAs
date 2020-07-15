SELECT 
	b.id_form_bd_item,
	a.bd_number,b.name as description,
	b.real_amount as original_amount,
	(b.real_amount * f.value) as idr_amout,
	c.percentage as rate_pph,
	(b.real_amount * f.value * c.percentage / 100) as pph_amount,
	b.id_currency,f.value as currency,
	d.name as wht_code
FROM form_bd a 
join form_bd_item b on a.id_form_bd=b.id_form_bd
join form_bd_item_pph c on c.id_form_bd_item=b.id_form_bd_item
join sub_tax d on d.id_sub_tax=c.id_sub_tax
join currency e on e.id_currency=b.id_currency
join currency_value f on f.id_currency=e.id_currency


SELECT 
`form_bd_item`.`id_form_bd_item`, 
`form_bd`.`bd_number`, `form_bd_item`.`name` as `description`, 
`form_bd_item`.`real_amount` as `original_amount`, 
(form_bd_item.real_amount * currency_value.value) as idr_amount 
FROM `form_bd` JOIN `currency_value` ON `currency_value`.`id_currency`=`currency`.`id_currency` 
JOIN `currency` ON `currency`.`id_currency`=`form_bd_item`.`id_currency` 
JOIN `sub_tax` ON `sub_tax`.`id_sub_tax`=`form_bd_item_pph`.`id_sub_tax` 
JOIN `form_bd_item_pph` ON `form_bd_item_pph`.`id_form_bd_item`=`form_bd_item`.`id_form_bd_item` 
JOIN `form_bd_item` ON `form_bd_item`.`id_form_bd`=`form_bd`.`id_form_bd`


select channel.id_channel as channel_id, max(case when package.id_package='1' then 1 else 0 end) as big_universe, max(case when package.id_package='2' then 1 else 0 end) as big_star, max(case when package.id_package='3' then 1 else 0 end) as big_sun, max(case when package.id_package='4' then 1 else 0 end) as big_fun, max(case when package.id_package='5' then 1 else 0 end) as big_deal from channel left join channel_category on channel_category.id_channel_category=channel.id_channel_category left join package_channel on package_channel.id_channel=channel.id_channel left join package on package.id_package=package_channel.id_package where channel.is_delete = 0 group by channel_category.category_name, channel.name

SELECT 
	
	(b.real_amount * f.value * c.percentage / 100) as pph_amount,
	case when g.id_tax='1' then (b.real_amount * f.value * c.percentage / 100) else 0 end as pph_23 ,
	case when g.id_tax='2' then (b.real_amount * f.value * c.percentage / 100) else 0 end as pph_26 ,
	case when g.id_tax='3' then (b.real_amount * f.value * c.percentage / 100) else 0 end as pph_4 ,
	case when g.id_tax='4' then (b.real_amount * f.value * c.percentage / 100) else 0 end as pph_21 
	
	
FROM form_bd a 
join form_bd_item b on a.id_form_bd=b.id_form_bd
join form_bd_item_pph c on c.id_form_bd_item=b.id_form_bd_item
join sub_tax d on d.id_sub_tax=c.id_sub_tax
join tax g on g.id_tax=d.id_tax
join currency e on e.id_currency=b.id_currency
join currency_value f on f.id_currency=e.id_currency