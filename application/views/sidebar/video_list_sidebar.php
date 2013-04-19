<?php $this->load->helper('search_helper'); ?>
<div class="well sidebar-nav">

<form action="<?php echo site_url('portal_video/search_video'); ?>" method="post" >
       
       <ul class="nav nav-list">
          <li class="nav-header"><i class="icon-search"></i> Search Video</li>         
          <li class="nav-header">Video Name</li>
          <li><input type="text" name="video_name" id="video_name" value="<?php echo search_text('search_video_name'); ?>" class="sidebar-input" /></li> 
          
          <?php if($this->ion_auth->is_admin()){ ?>          

          <li class="nav-header">Publisher</li>
          <li>

          <select name="publisher" id="publisher" class="sidebar-input" >
                <option value="">All Publisher</option>
                <?php if(isset($publisher_list)) : foreach($publisher_list as $row) : ?>
                <option value="<?php echo $row->id; ?>" <?php echo search_selected('search_publisher',$row->id); ?> ><?php echo $row->username; ?></option>
                <?php endforeach; ?>
                <?php endif; ?>                
          </select>
             
          </li>

          <?php } ?>
             
          <li class="nav-header">Status</li>
          <li>

          <select name="video_status" id="video_status" class="sidebar-input" >                
                <option value="Y" <?php echo search_selected('search_video_status','Y'); ?> >Active</option>
                <option value="N" <?php echo search_selected('search_video_status','N'); ?> >In Active</option>
                <option value="" <?php echo search_null('video_status'); ?> >All Status</option>                   
          </select> 

          </li>
          <li><br/><button href="#" class="btn btn-success">Search</button></li>       
       </ul>

</form>

</div><!--/.well -->