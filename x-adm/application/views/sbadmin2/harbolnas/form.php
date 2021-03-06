<div class="row">
    <div class="col-lg-12">
        <div class="form-message">
            <?php 
            if (isset($form_message)) {
                echo $form_message;
            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?=$page_title?> Form
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action,'role="form" enctype="multipart/form-data"'); ?>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="<?= (isset($post['title'])) ? $post['title'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="teaser">Teaser</label>
                                <textarea class="form-control" name="teaser" id="teaser" rows="8"><?= (isset($post['teaser'])) ? $post['teaser'] : '' ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control ckeditor" name="description" id="description" rows="8"><?= (isset($post['description'])) ? $post['description'] : '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="is_active" id="is_active" <?= (isset($post['is_active']) && !empty($post['is_active'])) ? 'checked="checked"' : '' ?>/>Active
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="thumbnail_image">Thumbnail Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php /* if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != '' && file_exists(UPLOAD_DIR . 'news/' . $post['thumbnail_image'])): ?>
                                            <img src="<?= RELATIVE_UPLOAD_DIR . 'news/' . $post['thumbnail_image'] ?>" id="post-image" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_news'] ?>" data-type="thumbnail">x</span>
                                        <?php endif; */ ?>                                 
                                        <?php if (isset($post['thumbnail_image']) && $post['thumbnail_image'] != ''): ?>
                                            <img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$post['thumbnail_image']?>" id="post-image" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_harbolnas'] ?>" data-type="thumbnail">x</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                            <input type="file" name="thumbnail_image">
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="primary_image">Primary Image</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail fileinput-upload" style="width: 200px; height: 150px;">
                                        <?php /* if (isset($post['primary_image']) && $post['primary_image'] != '' && file_exists(UPLOAD_DIR . 'news/' . $post['primary_image'])): ?>
                                            <img src="<?= RELATIVE_UPLOAD_DIR . 'news/' . $post['primary_image'] ?>" id="post-image" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_news'] ?>" data-type="primary">x</span>
                                        <?php endif; */ ?>                                        
                                        <?php if (isset($post['primary_image']) && $post['primary_image'] != ''): ?>
                                            <img src="<?=AZURE_BLOB_URLPREFIX.AZURE_FOLDER_UPLOADS.'/'.$post['primary_image']?>" id="post-image" />
                                            <span class="btn btn-danger btn-delete-photo delete-picture" id="delete-picture" data-id="<?= $post['id_harbolnas'] ?>" data-type="primary">x</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                            <input type="file" name="primary_image">
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:50px;">
                        <div class="col-lg-4 col-lg-offset-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a class="btn btn-danger" href="<?=$cancel_url?>">Cancel</a>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                <?php echo form_close(); ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
    $(function() {
        $("#forever").change(function() {
            var self = $(this);
            if (self.prop('checked') == true) {
                $("#end_date").attr('disabled',true);
                $("#end_date").val('');
                $(".input-group-addon.end_date").addClass('blocked');
            } else {
                $("#end_date").removeAttr('disabled');
                $(".input-group-addon.end_date").removeClass('blocked');
            }
        });
        $("#forever").trigger('change');
        <?php if (isset($post['id_harbolnas'])): ?>
        $(".delete-picture").click(function() {
            var self = $(this);
            var id = self.attr('data-id');
            var type = self.attr('data-type');
            var post_delete = [{name:"id",value:id},{name:"type",value:type}];
            post_delete.push({name:token_name,value:token_key});
            $.ajax({
                url:'<?=$delete_picture_url?>',
                type:'post',
                data:post_delete,
                dataType:'json',
                beforeSend: function() {
                    self.attr('disabled',true);
                }
            }).always(function() {
                self.removeAttr('disabled');
            }).done(function(data) {
                if (data['error'])  {
                    $(".flash-message").html(data['error']);
                }
                if (data['success']) {
                    $(".flash-message").html(data['success']);
                    //$("#post-image").remove();
                    self.prev('#post-image').remove();
                    self.remove();
                }
            });
        });
        <?php else: ?>
        $("#title").keyup(function() {
            $("#uri_path").val(convert_to_uri(this.value));
        });
        <?php endif; ?>
    });
</script>
