select 
a.form_id,sum(a.amount) as total_amount,
sum(b.total_pph) as total_pph, 
sum(b.total_ppn) as total_ppn,
(select sum(case when (a.id_status_pajak = 1) then (10/100) * a.real_amount * b.curs_finance else 0 end ) from form_bd_item a join form_bd b on a.id_form_bd=b.id_form_bd where a.id_form_bd = 9) as ppn,
sum(a.amount) + (select sum(case when (a.id_status_pajak = 1) then (10/100) * a.real_amount * b.curs_finance else 0 end ) from form_bd_item a join form_bd b on a.id_form_bd=b.id_form_bd where a.id_form_bd = 9) - sum(b.total_pph) as net_amount 
from 
        (select distinct

                
                form_id,
                id_form_bd_item,
                amount from (SELECT a.id_form_bd as form_id,
                a.id_form_bd_item,(a.real_amount * e.curs_finance) as amount , 
                (a.real_amount * b.percentage / 100 * e.curs_finance) as pph ,
                e.curs_finance

        FROM `form_bd_item` a 
        left join form_bd_item_pph b on a.id_form_bd_item = b.id_form_bd_item
        
        join form_bd e on e.id_form_bd=a.id_form_bd
        where a.id_form_bd = 9) as table_ahay
        ) a 
inner join
        (select 
                form_id,
                id_form_bd_item , 
                sum(pph)  as total_pph , 
                sum(ppn) as total_ppn  
        from 
                (SELECT 
                        e.curs_finance,
                        a.id_form_bd as form_id ,
                        a.id_form_bd_item,
                        (a.real_amount * e.curs_finance) as amount , 
                        (a.real_amount * b.percentage / 100 * e.curs_finance) as pph ,
                        (case when (a.id_status_pajak = 1) then (10/100) * (a.real_amount * e.curs_finance) else 0 end ) as ppn

        FROM `form_bd_item` a 
        left join form_bd_item_pph b on a.id_form_bd_item = b.id_form_bd_item
        
        join form_bd e on e.id_form_bd=a.id_form_bd
        where a.id_form_bd = 9) as tabel_pph
        group by id_form_bd_item) b on a.form_id = b. form_id and a.id_form_bd_item = b.id_form_bd_item