<script src="<?=GLOBAL_JS_URL?>mygrid.js"></script>
<style type="text/css">
.mB20p{
    margin-bottom: 20px;
}
</style>
<section class="well animated fadeInUp">
    <div class="row">
        <div class="col-md-12">
            <div class='text-right'>
               <a class="btn btn-success export_excel" data-type="1"><i class="icon-plus-sign"></i> Excel</a> 
               <a class="btn btn-default export_excel" data-type="2"><i class="icon-plus-sign"></i> CSV</a>
            </div>
        </div>
    </div> 
    <?php
        if(isset($flash_message)){
            echo $flash_message;
        }
    ?> 
    <hr>
    <div id='list_data'>

        <?php echo form_open($export_excel,'id="form-export" role="form" enctype="multipart/form-data"'); ?>
        <input type="hidden" id="type_export" name="type_export" value="" />
            <div class="form-inline mB20p">
                <div class="form-group">
                    <button type="button" class="btn reload" title='Reload Data'><i class="fa fa-refresh"></i></button>
                </div>
                <div class="form-group">
                    <select class='form-control input-sm perpage' style='margin-bottom:0;width:125px;'>
                        <optgroup label='Show per page'>
                            <option value='5'>5</option>
                            <option value='10'>10</option>
                            <option value='50'>50</option>
                            <option value='100'>100</option>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group date mW300" id="datePublish">
                        <input type="text"   value="<?=date('Y-m-d')?>" name="publish_date"  data-date-format="YYYY-MM-DD" class="form-control date-created-start" >
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group date mW300" id="datePublishEnd">
                        <input type="text"   value="<?=date('Y-m-d')?>" name="publish_dates"  data-date-format="YYYY-MM-DD" class="form-control date-created-end" >
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn search_date" title='Reload Data'><i class="fa fa-search"></i></button>
                </div>
           </div>
            
            
            <!-- start listing data -->
            <table class="table table-striped table-bordered table-hover">
                <thead> 
                    <tr>
                        <th class="center" style='width:1px;'>No</th>
                        <th class="center" style="width:20%;" title="Sort" id="bd_number">No. Dokumen Pajak <span></span></th>
                        <th class="center" style="width:20%;" title="Sort" id="vendor">Tanggal Dokumen Pajak <span></span></th>
                        <th class="center" style="width:10%;" title="Sort" id="npwp">Nama <span></span></th>
                        <th class="center" style="width:20%;">Jumlah Dpp <span></span></th>
                        <th class="center" style="width:20%;">Jumlah PPn <span></span></th>
                        
                    <tr>
                        <th></th>
                        <th class="center"><input type="text" name="bd_number" placeholder="Search" class="ppn form-control" id="search_bd_number" style="width:100%;"></th>
                        <th class="center"><input type="text" placeholder="Search" class="ppn form-control" id="search_vendor" style="width:100%;"></th>
                        <th class="center"><input type="text" placeholder="Search" class="ppn form-control" id="search_npwp" style="width:100%;"></th>
                        <th><input type="text" placeholder="Search" class="ppn form-control" id="search_original_amount" style="width:100%;"></th>
                        <th><input type="text" placeholder="Search" class="ppn form-control" id="search_idr_amount" style="width:100%;"></th>
                        
                        
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        <?php echo form_close(); ?>
        <!-- end of listing data -->
        <hr/>
        <div class="row">
            <div class="col-md-12 text-right">
                <!-- <a class="btn btn-primary" href="<?= $add_url ?>"><i class="icon-plus-sign"></i> Add New</a> -->
            </div>
        </div>
    </div>
</section>

<br/><br/>
<script type="text/javascript">
    
        
    $('.export_excel').click(function (){
        //alert($(this).attr('data-type'));
        $('#type_export').val($(this).attr('data-type'));
        $('#form-export').submit();
    });
    the_grid('list_data', '<?= $url_data ?>',1, 10,<?=$page?>,'bd_number');
    // list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>
