select 
(a.real_amount + 
	(case when (a.id_status_pajak = 1) then (10/100) * a.real_amount else 0 end) - 
	((case when(
		select sum(a.real_amount * b.percentage/100) 
		from 
		form_bd_item a 
		left join form_bd_item_pph b on a.id_form_bd_item=b.id_form_bd_item 
		where a.id_form_bd_item=$id_form_bd_item is null
		) then (
		select sum(a.real_amount * b.percentage/100) 
		from form_bd_item a 
		left join form_bd_item_pph b on a.id_form_bd_item=b.id_form_bd_item 
		where a.id_form_bd_item=$id_form_bd_item) else 0 end)
	)) as net_amount 
from form_bd_item a 
join currency c on a.id_currency=c.id_currency 
where a.id_form_bd_item=$id_form_bd_item