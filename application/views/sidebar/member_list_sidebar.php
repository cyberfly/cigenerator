<?php $this->load->helper('search_helper'); ?>
<div class="well sidebar-nav">

<form action="<?php echo site_url('member/search_member'); ?>" method="post" >
       
       <ul class="nav nav-list">
          <li class="nav-header"><i class="icon-search"></i> Search Member</li>         
          <li class="nav-header">Member Username</li>
          <li><input type="text" name="member_username" id="member_username" value="<?php echo search_text('search_member_username'); ?>" class="sidebar-input" /></li>         
               
          <li class="nav-header">Status</li>
          <li>

          <select name="member_status" id="member_status" class="sidebar-input" >                
                <option value="1" <?php echo search_selected('search_member_status','1'); ?> >Active</option>
                <option value="10" <?php echo search_selected('search_member_status','10'); ?> >In Active</option>
                <option value="" <?php echo search_null('member_status'); ?> >All Status</option>                   
          </select> 

          </li>
          <li><br/><button href="#" class="btn btn-success">Search</button></li>       
       </ul>

</form>

</div><!--/.well -->