
	
	<div class="page-header">
	<h1>Select Table (1 of 2) <small>Select table to generate MVC</small></h1>
	</div>

    <?php $this->load->view('template/show_error'); ?>

	<form class="form-horizontal" method="post" action="<?php echo site_url('generator/step_2'); ?>" enctype="multipart/form-data" >
    <fieldset>

    <div class="control-group">
        <label class="control-label" for="input01">Table Name *</label>
        <div class="controls">
            <select name="table_name" id="table_name" >
                <?php if(isset($table_records)) : foreach($table_records as $row) : ?>
                    <option value="<?php echo $row; ?>" ><?php echo $row; ?></option>
                <?php endforeach; ?>
                <?php endif; ?>                
            </select>
        </div>
    </div>        
    
    <div class="form-actions">
            <input type="submit" class="btn btn-primary" value="Continue">            
    </div>

    </fieldset>
    </form>
		
		
		
		
		