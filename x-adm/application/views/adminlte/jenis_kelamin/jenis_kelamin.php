<table class="table table-striped table-bordered table-hover" id="dataTables-list">
    <thead>
        <tr>
            <th data-searchable="false" data-orderable="false" data-name="actions" data-classname="text-center"></th>
            <th data-name="jenis_kelamin">Jenis Kelamin</th>
            <th data-name="is_active">Status</th>
            <th data-name="created_date" data-searchable="false">Created Date</th>
        </tr>
    </thead>
</table>

<br/><br/>
<input type="hidden" id="delete-record-field"/>
<div class="row">
    <div class="col-md-4 col-md-offset-8 text-right">
        <a href="<?=$add_url?>" class="btn btn-success">Add</a>
        <button type="button" class="btn btn-danger" id="delete-record">Delete</button>
    </div>
</div>
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list','<?= $url_data ?>');
</script>