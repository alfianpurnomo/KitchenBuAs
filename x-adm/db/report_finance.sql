create view view_report_finance as 
SELECT 

a.bd_number as no_bd,
a.id_form_bd as no_form_bd,
h.date_of_paid,
h.bd_paid_number,
e.name as divisi,
(case
 WHEN a.payment_type = 1 THEN 'Full Payment'
 WHEN a.payment_type = 2 THEN 'Advance'
 WHEN a.payment_type = 3 then 'Partial'
 end) as payment_type,
f.invoice_number,
h.spending_amount as spending_amount,
(SELECT sum(b.real_amount) FROM form_bd a 
join form_bd_item  b on a.id_form_bd=b.id_form_bd
where a.bd_number = no_bd) as dpp,
(SELECT sum(case when (b.id_status_pajak = 1) then (10/100) * b.real_amount else 0 end) FROM form_bd a join form_bd_item b on a.id_form_bd=b.id_form_bd where a.bd_number = no_bd) as VAT,
(case when (select sum(a.real_amount * b.percentage/100)
        from form_bd_item a
		left join  form_bd_item_pph b on a.id_form_bd_item=b.id_form_bd_item		
		where a.id_form_bd=no_form_bd) is null then 0 else (select sum(a.real_amount * b.percentage/100)
        from form_bd_item a
		left join  form_bd_item_pph b on a.id_form_bd_item=b.id_form_bd_item		
		where a.id_form_bd=no_form_bd) end
) as WHT,
((SELECT sum(b.real_amount) FROM form_bd a 
join form_bd_item  b on a.id_form_bd=b.id_form_bd
where a.bd_number = no_bd)+(SELECT sum(case when (b.id_status_pajak = 1) then (10/100) * b.real_amount else 0 end) FROM form_bd a join form_bd_item b on a.id_form_bd=b.id_form_bd where a.bd_number = no_bd)-(case when (select sum(a.real_amount * b.percentage/100)
        from form_bd_item a
		left join  form_bd_item_pph b on a.id_form_bd_item=b.id_form_bd_item		
		where a.id_form_bd=no_form_bd) is null then 0 else (select sum(a.real_amount * b.percentage/100)
        from form_bd_item a
		left join  form_bd_item_pph b on a.id_form_bd_item=b.id_form_bd_item		
		where a.id_form_bd=no_form_bd) end)) total,
((SELECT sum(b.real_amount) FROM form_bd a 
join form_bd_item  b on a.id_form_bd=b.id_form_bd
where a.bd_number = no_bd)+(SELECT sum(case when (b.id_status_pajak = 1) then (10/100) * b.real_amount else 0 end) FROM form_bd a join form_bd_item b on a.id_form_bd=b.id_form_bd where a.bd_number = no_bd)-(case when (select sum(a.real_amount * b.percentage/100)
        from form_bd_item a
		left join  form_bd_item_pph b on a.id_form_bd_item=b.id_form_bd_item		
		where a.id_form_bd=no_form_bd) is null then 0 else (select sum(a.real_amount * b.percentage/100)
        from form_bd_item a
		left join  form_bd_item_pph b on a.id_form_bd_item=b.id_form_bd_item		
		where a.id_form_bd=no_form_bd) end)-h.spending_amount) as sisa_bayar,
c.name as vendor,
(select GROUP_CONCAT(name) from form_bd_item where id_form_bd=no_form_bd) as description
FROM form_bd a 
left join form_bd_item b on a.id_form_bd=b.id_form_bd
join vendor c on b.id_vendor=c.id_vendor 
join vendor_category d on d.id_vendor_category=c.id_category_vendor
left join divisi e on a.id_divisi=e.id_divisi
left join invoice f on a.bd_number=f.bd_number
left join invoice_item g on f.id_invoice=g.id_invoice
left join invoice_payment h on h.id_invoice=g.id_invoice
where a.is_delete = 0
GROUP BY b.id_vendor,a.bd_number,h.bd_paid_number
ORDER by a.bd_number ASC

