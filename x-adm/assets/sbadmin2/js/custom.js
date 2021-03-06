/**
 * custom script
 * @author ivan lubis
 * @version 2.0
 * @description this library is required jquery and other library
 */
function ajax_post_form(url,data) {
    data.push({name:token_name,value:token_key});
    
    var callback = $.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:data,
        cache:false,
        beforeSend:function() {
            
        },
        complete: function() {
            
        }
    });
    return callback;
}
function convert_to_uri(val)
{
    return val
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}
function list_dataTables(element,url) {
    $(document).ready(function () {
        var selected = [];
        var sort = [];
        if ($(element+' thead th.default_sort').index(element+' thead th') > 0) {
            sort.push([$(element+' thead th.default_sort').index(element+' thead th'),"desc"]);
        }
        var colom = [];
        var i=0;
        $(element+' thead th').each(function() {
            var edit = $(this).data('edit');
            var view = $(this).data('view');
            colom[i] = {
                'data':(typeof $(this).data('name') === 'undefined') ? null : $(this).data('name'),
                'name':(typeof $(this).data('name') === 'undefined') ? null : $(this).data('name'),
                'searchable':(typeof $(this).data('searchable') === 'undefined') ? true : $(this).data('searchable'),
                'sortable':(typeof $(this).data('orderable') === 'undefined') ? true : $(this).data('orderable'),
                'className':(typeof $(this).data('classname') === 'undefined') ? null : $(this).data('classname')
            };
            i++;
        });
        //console.log(colom);
        var DTTable = $(element).DataTable({
            "processing": true,
            "serverSide": true,
            /*"ajax": $.fn.dataTable.pipeline({
                url: url,
                pages: perpage // number of pages to cache
            })*/
            "ajax": {
                "url": url,
                "type": "POST",
                "data": objToken
            },
            "rowCallback": function( row, data ) {
                if ( $.inArray(data.DT_RowId, selected) !== - 1) {
                    $(row).addClass('selected');
                }
            },
            "columns":colom,
            "order":sort
        });
        /*
        // edit record
        //$(element+' tbody').on('click', 'td.details-control', function () {
        $(element+' tbody').on('click', 'td.details-control span', function () {
            var selfspan = $(this);
            var selfurl = selfspan.data('url');
            var tr = this.closest('tr');
            var id = tr.id;
            window.location.href = current_ctrl+selfurl+'/'+id;
        });
        */
        // selected row
        $(element+' tbody').on('click', 'tr', function () {
            var id = this.id;
            var index = $.inArray(id, selected);

            if ( index === -1 ) {
                selected.push( id );
            } else {
                selected.splice( index, 1 );
            }
            $("#delete-record-field").val(selected);

            $(this).toggleClass('selected');
        });
        // delete record
        $(document).on('click', '#delete-record', function () {
            if (selected.valueOf() != '') {
                //console.log(objToken);
                var post_delete = [{name:"ids",value:selected}];
                post_delete.push({name:token_name,value:token_key});
                var url_delete = (typeof $(this).data('delete-url') === 'undefined') ? current_ctrl+'delete' : $(this).data('delete-url');
                var conf = confirm('Are You sure want to delete this record(s)?');
                if (conf) {
                    $.ajax({
                        url:url_delete,
                        type:'post',
                        data:post_delete,
                        dataType:'json'
                    }).
                    done(function(data) {
                        if (data['success']) {
                            $(".flash-message").html(data['success']);
                            $(element+' tbody tr.selected').remove();
                            DTTable.draw();
                        }
                        if (data['error']) {
                            $(".flash-message").html(data['error']);
                        }
                    })
                    ;
                }
            }
        });
        // delete record new
        $(document).on('click', '#delete-records', function () {
            if (selected.valueOf() != '') {
                //console.log(objToken);
                var post_delete = [{name:"ids",value:selected}];
                post_delete.push({name:token_name,value:token_key});
                var link = $(this).attr('data-link');
                var conf = confirm('Are You sure want to delete this record(s)?');
                if (conf) {
                    $.ajax({
                        url:current_ctrl+link,
                        type:'post',
                        data:post_delete,
                        dataType:'json'
                    }).
                    done(function(data) {
                        if (data['success']) {
                            $(".flash-message").html(data['success']);
                            $(element+' tbody tr.selected').remove();
                            DTTable.draw();
                        }
                        if (data['error']) {
                            $(".flash-message").html(data['error']);
                        }
                    })
                    ;
                }
            }
        });
    });
}
