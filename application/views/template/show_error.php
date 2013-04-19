		<?php
		if($this->session->flashdata('success'))
		{
		?>

		<div class="alert alert-success fade in">
		<a class="close" data-dismiss="alert" href="#">&times;</a>
		<?php echo $this->session->flashdata('success'); ?>
		</div>

		<?php }
		else if($this->session->flashdata('error'))
		{
		?>

		<div class="alert alert-error fade in">
		<a class="close" data-dismiss="alert" href="#">&times;</a>
		<?php echo $this->session->flashdata('error'); ?>
		</div>

		<?php }
		else if ($this->session->flashdata('not_available'))
		{
		?>

		<div class="alert alert-error fade in">
		<a class="close" data-dismiss="alert" href="#">&times;</a>
		<p><?php echo $this->session->flashdata('not_available');?></p>
		</div>

		<?php }
		if(validation_errors())
		{
		?>
		<div class="alert alert-block alert-error fade in">
		<a class="close" data-dismiss="alert" href="#">&times;</a>
		<h4 class="alert-heading">Oh snap! You got an error!</h4>
		<ul>
		<?php echo validation_errors('<li>', '</li>'); ?>
		</ul>
		</div>
		<?php } ?>