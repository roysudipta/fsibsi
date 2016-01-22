<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends FB_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Gallery_model');
    }

    public function index() {
        $data = array();
        $this->_AdminView(PAGE_ADMIN_GALLERY, $data);
    }

    public function get_child_albums() {
        $data['main_event'] = trim(addslashes($this->input->post("main_event")));
        $data['parent_id'] = trim(addslashes($this->input->post("parent_id")));
        $level = trim(addslashes($this->input->post("level")));

        $breadcrumb = array();

        if ($data['parent_id'] != 0) {

            $parent_id = $data['parent_id'];
            for ($i = $level; $i > 0; $i--) {
                $get_album_details = $this->Gallery_model->get_album_details($parent_id);
                if (!empty($get_album_details)) {
                    $parent_id = $get_album_details['parent_id'];
                    if ($i == $level) {
                        array_push($breadcrumb, '<span class="caption-subject font-green-sharp bold ">' . ucwords(stripslashes($get_album_details['display_name'])) . '</span>');
                    } else {
                        array_push($breadcrumb, '<span class="caption-subject font-green-sharp bold "><a href="javascript:void(0);" class="parent_album" onclick="getChildElements(' . "'" . $get_album_details['main_event'] . "'" . ',' . $get_album_details['id'] . ',' . $get_album_details['level'] . ');">' . stripslashes($get_album_details['display_name']) . '</a>></span>');
                    }
                }
            }
        }
        if($level>0)
        {
            array_push($breadcrumb, '<span class="caption-subject font-green-sharp bold "><a href="javascript:void(0);" class="parent_album" onclick="getChildElements(' . "'" . $this->input->post("main_event") . "'" . ',0,0);">' . ucwords($this->input->post("main_event")) . '</a>></span>');
        }
        else
        {
            array_push($breadcrumb, '<span class="caption-subject font-green-sharp bold ">' . ucwords($this->input->post("main_event")) . '</span>');
        }
        array_push($breadcrumb, '<span class="caption-subject font-green-sharp bold "><a href="' . base_url() . FN_LIST_GALLERY . '">Gallery</a>></span>');
  

        $data['getAllChildAlbums'] = $this->Gallery_model->getAllChildElement($data['main_event'], $data['parent_id'], CONST_GALLERY_TYPE_ALBUM);
        $data['getAllChildPhotos'] = $this->Gallery_model->getAllChildElement($data['main_event'], $data['parent_id'], CONST_GALLERY_TYPE_PHOTO);
        $data['breadcrumb'] = $breadcrumb;
        $data['level'] = $level;

        echo $content = $this->load->view(PAGE_ADMIN_GALLERY_FILE_LISTING, $data, TRUE);
    }

    public function create_new_album() {
        $display_name = trim(addslashes($this->input->post("display_name")));
        $level = trim(addslashes($this->input->post("level")));
        $main_event = trim(addslashes($this->input->post("main_event")));
        $parent_id = trim(addslashes($this->input->post("parent_id")));

        $getMaxLevel = $this->Gallery_model->getMaxLevel($main_event);
        $isAlbumNameExists = $this->Gallery_model->isAlbumNameExists($main_event,$level+1,$display_name);

        $calcute_level = $level-$getMaxLevel['level'];   
       
        if($display_name=='') {
            echo 'error~<div class="alert alert-danger">Album title can not be blank.</div>';
        }
        elseif($isAlbumNameExists>0)
        {
           echo 'error~<div class="alert alert-danger">Album title is already exists.</div>'; 
        }
        elseif($calcute_level >=2 )  {
            echo 'error~<div class="alert alert-danger">Parent album does not exists.</div>';
        }
        else
        {
            $data = array(
                'level'         => $level,
                'main_event'    => $main_event,
                'file_name'     => md5($display_name),
                'is_type'       => CONST_GALLERY_TYPE_ALBUM,
                'level'         => ($level+1),
                'parent_id'     => $parent_id,
                'display_name'  => $display_name
             );
            
            $id = $this->Gallery_model->insert_new_album($data);
            $latest_level = $level+1;
            echo 'success~<div class="alert alert-success">Your new album has been successfully created.</div>~';?>
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
                            //alert(data);
                       if(data=='success')
                         {
                            $('.record_ajax').hide();
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
                          //$('#general_alert').removeClass('alert alert-success');

                        }
                    });
                });
            });

    </script><div class="col-xs-12 col-md-2 album"><a href="javascript:void(0);" class="cross" style="position:absulate;" data-id="<?php echo $id?>"><i class="fa fa-minus-circle" ></i></a><a href="javascript:void(0);" class="parent_album" onclick="getChildElements('<?php echo $main_event?>',<?php echo $id?>,<?php echo $latest_level?>);"><img height="80" width="80" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE; ?>album.png"  alt="" class="img-responsive"><span><?php echo ucwords(stripslashes($display_name))?></span></a></div>

<?php   }
    }
    public function delete_album()
    {
        $id = $this->input->post("id");
        $child_album_details = $this->Gallery_model->child_album_details($id);
        if( $child_album_details >0)
        {
            echo 'error';
        }
        else
        {
            $this->Gallery_model->delete_album($id);   
            echo 'success';
        }
        
    }
    public function delete_photo()
    {
        $id = $this->input->post("id");
        $get_photo_details = $this->Gallery_model->get_photo_details($id);
        unlink(CONST_PATH_GALLERY.$get_photo_details['display_name']);
        $this->Gallery_model->delete_image($id);   
        echo 'success';
        
        
    }
    
    public function upload_photo()
    {
        $file_name = $_FILES["file_name"]["name"];
        $img_size = $_FILES["file_name"]["size"] ;
        $img_type = $_FILES["file_name"]["type"] ;
        

        $validextensions = array("jpeg", "jpg", "png","gif");
        $temporary = explode(".", $file_name);
        $file_extension = end($temporary);

        $width = $this->input->post("width");
        $height = $this->input->post("height");
        $level = $this->input->post("hidden_level");
        $parent_id = $this->input->post("hidden_parent_id");
        $main_event = $this->input->post("hidden_main_event");
        $getMaxLevel = $this->Gallery_model->getMaxLevel($main_event);
        $get_max_order = $this->Gallery_model->get_max_order($parent_id);

        $calcute_level = $level-$getMaxLevel['level'];   
        if($file_name=='')
        {
            echo 'error~<div class="alert alert-danger">Please upload your profile picture.</div>';
        }
        elseif (($img_type != "image/png" || $img_type != "image/jpg" || $img_type != "image/jpeg" || $img_type != "image/gif") && $img_size > 100000 && !in_array($file_extension, $validextensions)) 
        {
             echo 'error~<div class="alert alert-danger">Uploaded picture must be in jpg,jpeg,png format and less than 10MB.</div>';
        }
        elseif($width > USER_GALLERY_IMAGE_WIDTH_MAX || $height>USER_GALLERY_IMAGE_HEIGHT_MAX)
        {
            echo 'error~<div class="alert alert-danger">Uploaded image resolution is '.$width.'X'.$height.' and it must be less than or equal '.USER_GALLERY_IMAGE_WIDTH_MAX.'X'.USER_GALLERY_IMAGE_HEIGHT_MAX.'.</div>';
        }
        elseif($width < USER_GALLERY_IMAGE_WIDTH_MIN || $height < USER_GALLERY_IMAGE_HEIGHT_MIN)
        {
            echo 'error~<div class="alert alert-danger">Uploaded image resolution is '.$width.'X'.$height.' and it must be greater than or equal '.USER_GALLERY_IMAGE_WIDTH_MIN.'X'.USER_GALLERY_IMAGE_HEIGHT_MIN.'.</div>';
        }
        elseif($calcute_level >=2 )  {
            echo 'error~<div class="alert alert-danger">Parent album does not exists.</div>';
        }
        else
        {
            $filename=md5(time()).'_'.$file_name;
            move_uploaded_file($_FILES["file_name"]["tmp_name"],CONST_PATH_GALLERY.$filename);
            
            
           $latest_image_order = $get_max_order['image_order']+1;
            $data = array(
                'level'         => $level,
                'main_event'    => $main_event,
                'file_name'     => md5($filename),
                'is_type'       => CONST_GALLERY_TYPE_PHOTO,
                'level'         => ($level+1),
                'image_order'   => $latest_image_order,
                'parent_id'     => $parent_id,
                'display_name'  => $filename
             );
            
            $id = $this->Gallery_model->insert_new_album($data);

            echo 'success~';?>
            <script type="text/javascript">
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
                           // alert(data);
                        if(data=='success')
                        {
                            $('.record_ajax').hide();
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
            <div class="col-xs-12 col-md-3 photo" id="<?php echo $id?>"><a href="javascript:void(0);" class="delete_photo" style="position:absulate;" data-id="<?php echo $id?>"><i class="fa fa-minus-circle" ></i></a>
                 <a href="javascript:void(0);" class="parent_photo" ><img height="160" width="260" src="<?php echo base_url().CONST_PATH_GALLERY.$filename?>" alt="" class="img-responsive"></a>
            </div>
        <?php }
    }
    public function change_image_order()
    {
        
        $positions = $this->input->post("positions");
        

        $tmpArray = explode(';',$positions);
        $final_order = array();
        $count=0;
        
        for ($i=0; $i <count($tmpArray); $i++) { 
            $final_order[$i]= $tmpArray[$i];
            
        }
      
       for ($j=0; $j <count($final_order); $j++) { 
           
            $this->Gallery_model->update_image_order($final_order[$j]);

        }

    }

}
