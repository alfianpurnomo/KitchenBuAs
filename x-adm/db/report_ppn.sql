CREATE OR REPLACE VIEW `view_ppn` AS 
select 
	a.bd_number as bd_number,
	c.invoice_number as no_doc_invoice,
	c.tax_number as no_doc_tax,
	c.invoice_date as document_invoice_date,
	c.tax_date as document_tax_date,
	d.npwp as npwp,
	d.name as name,
	d.address as alamat,
	d.address_npwp as alamat_npwp,
	b.real_amount * b.curs_ppn as dpp,
	( b.real_amount *b.curs_ppn* 10/100) as jumlah_ppn,
	b.id_vendor
from form_bd a 
join form_bd_item b on a.id_form_bd=b.id_form_bd
join invoice c on a.bd_number=c.bd_number
join vendor d on b.id_vendor=d.id_vendor
where a.is_delete=0 and b.is_delete=0 and b.id_status_pajak=1