<?php $this->load->helper('search_helper'); ?>
<div class="well sidebar-nav">

<form action="<?php echo site_url('publisher/search_publisher'); ?>" method="post" >
       
       <ul class="nav nav-list">
          <li class="nav-header"><i class="icon-search"></i> Search Publisher</li>         
          <li class="nav-header">Publisher Username</li>
          <li><input type="text" name="publisher_username" id="publisher_username" value="<?php echo search_text('search_publisher_username'); ?>" class="sidebar-input" /></li>         
               
          <li class="nav-header">Status</li>
          <li>

          <select name="publisher_status" id="publisher_status" class="sidebar-input" >                
                <option value="1" <?php echo search_selected('search_publisher_status','1'); ?> >Active</option>
                <option value="10" <?php echo search_selected('search_publisher_status','10'); ?> >In Active</option>
                <option value="" <?php echo search_null('publisher_status'); ?> >All Status</option>                   
          </select> 

          </li>
          <li><br/><button href="#" class="btn btn-success">Search</button></li>       
       </ul>

</form>

</div><!--/.well -->