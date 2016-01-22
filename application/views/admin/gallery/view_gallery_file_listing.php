

<?php
/*echo '<pre>';
print_r($breadcrumb);
echo '</pre>';*/
krsort($breadcrumb);
/*echo '<pre>';
print_r($breadcrumb);
echo '</pre>';*/
foreach ($breadcrumb as $link) {
    echo $link;
}
?><br>


  <script type="text/javascript">
    $(function() {
    //coockie name
    
    $('div#parent_photo').sortable({
        revert: true,
        //observe the update event...
        update : function(event, ui) {
            
            var order = [];
            //loop trought each li...
            $('#parent_photo div').each(function(e) {
                //add each li position to the array...
                // the +1 is for make it start from 1 instead of 0
                order.push($(this).attr('id') + '=' + ($(this).index() + 1));
            });
            // join the array as single variable...
            var positions = order.join(';');
            //use the variable as you need!
            
             $.ajax({
            type: "POST",
            url: "<?php echo base_url().FN_GALLERY_CHANGE_IMAGE_ORDER ?>",
            data: {positions: positions},
            
            success: function (data) {
               //alert(data);
               
                
            }
            
            });
        }
    });
   
  
});
</script>
  
<!-- MODAL FORM -->
<div class="modal fade" id="create_new_album" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">New album</h4>

           <script type="text/javascript">
           $(document).ready(function () {
               $('#create_album_form').on('submit',function(e) {
                    var display_name = $('#display_name').val();
                    $('.field-error').removeClass('field-error');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url().FN_GALLERY_CREATE_NEW_ALBUM ?>",
                        data: {display_name: display_name,level:<?php echo $level?>,main_event:'<?php echo $main_event?>','parent_id':<?php echo $parent_id?>},
                        beforeSend: function(){
                            $('.loader_for_album_creation').show();
                        },
                        success: function (data) {
                           
                            var result = data.split("~");
                            if(result[0]=='success')
                            {
                             
                               $('.record_ajax').hide();  
                               $('.field-error').removeClass('field-error');
                               $( '#create_album_alert' ).html(result[1]);  
                               $('#parent_album').append(result[2]);
                               $('.record').remove();
                               $('#display_name').val('');
                               setTimeout(function(){
                                    $('.modal.in').modal('hide'); 
                                    $('#create_album_alert').hide();
                                 },2000);
        
                            }
                            else if(result[0]=='error')
                            {
                                $('#create_album_alert').show();
                                $( '#display_name' ).addClass( 'field-error' );  
                                $( '#create_album_alert' ).html(result[1]);  
                            }
                            else
                            {
                                $('#create_album_alert').show();
                                $( '#create_album_alert' ).html('<div class="alert alert-danger">Undefined error occurred.</div>');
                            }
                          
                            
                        },
                        complete: function(){
                            $('.loader_for_album_creation').hide();
                        } 
                    });
                    e.preventDefault();
               });
           });
           </script>

            <form id="create_album_form" class="form-horizontal" method="post" action="">
                <div class="form-body">
                    <div class="modal-body">

                        <div id="modal_alert" class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <div id="modal_alert_msg"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">

                                
                                <div class="form-group">
                                    <div id="create_album_alert"></div>
                                    <label class="control-label col-md-4">Title<span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="display_name" id="display_name" class="form-control" />
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    
                                    <img class="loader_for_album_creation" style="display:none;" src="<?php echo base_url().CONST_PATH_DEMO_IMAGE?>loading.gif" >
                                    <input id="submit" type="submit" class="btn green" value="Submit">
                                    <button id="cancel" type="button" class="btn default"data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
</div>
<div class="modal fade" id="upload_image" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Upload Photo</h4>

           <script type="text/javascript">
$(document).ready(function (e){
  var _URL = window.URL || window.webkitURL;

$("#file_name").change(function(e) {
    var image, file;
    if ((file = this.files[0])) {
        image = new Image();
        image.onload = function() {
            $('#width').val(this.width);
            $('#height').val(this.height);
        };

        image.src = _URL.createObjectURL(file);

    }

});
    $('#upload_photo_form').on('submit',function(e) {
            /*var display_name = $('#display_name').val();*/
            $('#submit_for_image').attr('disabled','disabled');
            $('.field-error').removeClass('field-error');
            $.ajax({
                
                url: "<?php echo base_url().FN_GALLERY_IMAGE_UPLOAD ?>",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                  $('.loader_for_image_upload').show();
                 },
                success: function (data) {
                   
                    var result = data.split("~");
                    //alert(data)
                    if(result[0]=='success')
                    {
                       $('#submit_for_image').removeAttr('disabled');
                       $('.record_ajax').hide();
                       $( '.field-error' ).removeClass('field-error');
                       $( '#photo_upload_alert' ).html('<div class="alert alert-success">Image has been successfully uploaded.</div>');  
                       $( '#parent_photo' ).append(result[1]);
                       $( '.record' ).remove();
                       $( '#file_name' ).val('');
                       setTimeout(function(){
                            $('.modal.in').modal('hide'); 
                            $('#photo_upload_alert').html('');
                             $('#blah').attr('src','<?php echo base_url().CONST_PATH_DEMO_IMAGE?>noimage.png');
                         },2000);

                    }
                    else if(result[0]=='error')
                    {
                        $( '#file_name' ).addClass( 'field-error' );  
                        $('#photo_upload_alert').show();
                        $( '#photo_upload_alert' ).html(result[1]); 
                        $('#submit_for_image').removeAttr('disabled'); 
                    }
                    else
                    {
                        $('#photo_upload_alert').show();
                        $( '#photo_upload_alert' ).html('<div class="alert alert-danger">Undefined error occurred.</div>');
                        $('#submit_for_image').removeAttr('disabled');
                    }
                    
                },
                complete: function(){
                    $('.loader_for_image_upload').hide();
                } 
            });
            e.preventDefault();
       });
  });
function readURL(input) {
   // alert('aa');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                var file_extension =  $('#file_name').val().split('.').pop().toLowerCase();
                if(file_extension=='jpg' ||file_extension=='jpeg' || file_extension=='gif' || file_extension=='png')
                {
                    reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                    }
                }
                else
                {     $("#file_name").val("")
                      $('#blah').attr('src','<?php echo base_url().CONST_PATH_DEMO_IMAGE?>noimage.png');
                      $('#width').val('');
                      $('#height').val('');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

            <form id="upload_photo_form" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="modal-body">

                       <!--  <div id="modal_alert" class="">
                            <button class="close" data-close="alert"></button>
                            <div id="modal_alert_msg"></div>
                        </div> -->
                        <div class="row">
                            <div class="col-xs-12">
                                
                                <div class="form-group">
                                    <div id="photo_upload_alert"></div>
                                    <label class="control-label col-md-4">Upload<span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <input type="hidden"  name="width"  id="width"  />
                                        <input type="hidden"  name="height"  id="height"  />
                                        <input type="hidden"  name="hidden_level"  id="hidden_level" value="<?php echo $level?>" />
                                        <input type="hidden"  name="hidden_main_event"  id="hidden_main_event" value="<?php echo $main_event?>" />
                                        <input type="hidden"  name="hidden_parent_id"  id="hidden_parent_id" value="<?php echo $parent_id?>" />
                                        <div>
                                            <img id="blah" src="<?php echo base_url().CONST_PATH_DEMO_IMAGE?>noimage.png" alt="Preview" width="150" height="150" />
                                        </div>
                                       
                                        <input type="file" name="file_name" id="file_name" class="form-control" onchange="readURL(this);" />
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    
                                    <img class="loader_for_image_upload" style="display:none;" src="<?php echo base_url().CONST_PATH_DEMO_IMAGE?>loading.gif" >
                                    <input id="submit_for_image" type="submit" class="btn green" value="Submit">
                                    <button id="cancel" type="button" class="btn default"data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
</div>
<a class="btn yellow-gold" data-toggle="modal" href="#create_new_album">Create new album <i class="fa fa-plus"></i></a>
<a class="btn yellow-gold" data-toggle="modal" href="#upload_image">Upload Photos <i class="fa fa-plus"></i></a>

<!-- /. MODAL FORM -->

<script type="text/javascript">
    $(document).ready(function(){
    $('.cross').on('click', function() {
        var id = $(this).data("id");
        var tmp_id = $(this);
        
        $('#general_alert').hide();
        $('#general_alert').removeClass('alert alert-danger');
        $('#general_alert').removeClass('alert alert-success'); 

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().FN_GALLERY_DELETE_ALBUM ?>",
            data: {id: id},
            success: function (data) {
            if(data=='success')
            {
                    $('#general_alert').addClass('alert alert-success');
                    $('#general_alert').show();
                    $('#general_alert_msg').html('Album has been successfully deleted.');
                    tmp_id.parent('div').remove();
            }
            else
            {
                    $('#general_alert').addClass('alert alert-danger');
                    $('#general_alert').show();
                    $('#general_alert_msg').html('You can not remove this album because it has sub folders.');
            }
              if ($('.delete_photo').length==0 && $('.cross').length==0) {
               $('.record_ajax').show();
              }
            
            }
        });
    });
});

</script>
<script type="text/javascript">
    $(document).ready(function(){
    $('.cross').on('click', function() {
        var id = $(this).data("id");
        var tmp_id = $(this);
        
        $('#general_alert').hide();
        $('#general_alert').removeClass('alert alert-danger');
        $('#general_alert').removeClass('alert alert-success'); 

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().FN_GALLERY_DELETE_ALBUM ?>",
            data: {id: id},
            success: function (data) {
            if(data=='success')
            {
                    $('#general_alert').addClass('alert alert-success');
                    $('#general_alert').show();
                    $('#general_alert_msg').html('Album has been successfully deleted.');
                    tmp_id.parent('div').remove();
            }
            else
            {
                    $('#general_alert').addClass('alert alert-danger');
                    $('#general_alert').show();
                    $('#general_alert_msg').html('You can not remove this album because it has sub folders.');
            }
             if ($('.delete_photo').length==0 && $('.cross').length==0) {
                $('.record_ajax').show();
              }
            
            }
        });
    });
});

</script><script type="text/javascript">
    $(document).ready(function(){
    $('.delete_photo').on('click', function() {
        var id = $(this).data("id");
        var tmp_id = $(this);
        
        $('#general_alert').hide();
        $('#general_alert').removeClass('alert alert-danger');
        $('#general_alert').removeClass('alert alert-success'); 

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().FN_GALLERY_DELETE_IMAGE ?>",
            data: {id: id},
            success: function (data) {
            if(data=='success')
            {
                    $('#general_alert').addClass('alert alert-success');
                    $('#general_alert').show();
                    $('#general_alert_msg').html('Image has been successfully deleted.');
                    tmp_id.parent('div').remove();
            }
            
             if ($('.delete_photo').length==0 && $('.cross').length==0) {
                $('.record_ajax').show();
              }
            
            }
        });
    });
});

</script>
   <div id="parent_album" class="row">         
<?php
if (count($getAllChildAlbums) > 0) {
    foreach ($getAllChildAlbums as $row_getAllChildAlbums) {
        ?>
        <div class="col-xs-12 col-md-2 album"><a href="javascript:void(0);" class="cross" style="position:absulate;" data-id="<?php echo $row_getAllChildAlbums['id']; ?>"><i class="fa fa-minus-circle" ></i></a>
            <a href="javascript:void(0);" class="parent_album" onclick="getChildElements('<?php echo $row_getAllChildAlbums['main_event'] ?>',<?php echo $row_getAllChildAlbums['id'] ?>,<?php echo $row_getAllChildAlbums['level'] ?>);"><img height="80" width="80" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE; ?>album.png" alt="" class="img-responsive"><span><?php echo ucwords(stripslashes($row_getAllChildAlbums['display_name']))?></span></a>
        </div>
        <?php
    }
}
echo '</div><div id="parent_photo" >';

if (count($getAllChildPhotos) > 0) {
    foreach ($getAllChildPhotos as $row_getAllChildPhotos) {
        ?>
        <div class="col-xs-12 col-md-3 photo" id="<?php echo $row_getAllChildPhotos['id']?>" ><a href="javascript:void(0);" class="delete_photo" style="position:absulate;" data-id="<?php echo $row_getAllChildPhotos['id']; ?>"><i class="fa fa-minus-circle" ></i></a>
            <a href="javascript:void(0);" class="parent_album" ><img height="160" width="260" src="<?php echo base_url() . CONST_PATH_GALLERY . stripslashes($row_getAllChildPhotos['display_name']); ?>" alt="" class="img-responsive"></a>
        </div>
        <?php
    }
}
echo '</div>';
if(count($getAllChildAlbums) == 0 && count($getAllChildPhotos) == 0)
{?>
   <div class="col-xs-12 col-md-6 no record">
       <p>Sorry! No record found.</p>
    </div> 
<?php }?>
<div class="col-xs-12 col-md-6 no record_ajax" style="display:none;">
    <p>Sorry! No record found.</p>
</div> 

