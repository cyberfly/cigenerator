<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package		CodeIgniter
* @author		Rick Ellis
* @copyright	Copyright (c) 2006, pMachine, Inc.
* @license		http://www.codeignitor.com/user_guide/license.html
* @link			http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* Code Igniter Search Helpers
*
* @package		CodeIgniter
* @subpackage	Helpers
* @category		Helpers
* @author       Muhammad Fathur Rahman < mhd.fathur@live.com >
*/

// ------------------------------------------------------------------------

function generate_button_key($action_name,$use_lang=TRUE)
{
	if($use_lang)
	{
		if($action_name=='save')
		{
			$button_key = '<?php echo $this->lang->line(\'save_button\'); ?>';
		}
		else if($action_name=='save_change')
		{
			$button_key = '<?php echo $this->lang->line(\'save_change_button\'); ?>';
		}
		else if($action_name=='cancel')
		{
			$button_key = '<?php echo $this->lang->line(\'cancel_button\'); ?>';
		}
	}
	else
	{
		if($action_name=='save')
		{
			$button_key = 'Save';
		}
		else if($action_name=='save_change')
		{
			$button_key = 'Save Changes';
		}
		else if($action_name=='cancel')
		{
			$button_key = 'Cancel';
		}

		$button_key = ucwords($button_key);
	}

	return $button_key;
}

function generate_add_form_header_key($object_name,$use_lang=TRUE)
{
	$object_name = strtolower($object_name);
	$object_name = str_replace(' ', '_', $object_name);

	if($use_lang)
	{
		$add_form_header_key = 'add_'.$object_name.'_header';
		$add_form_header_key = '<?php echo $this->lang->line(\''.$add_form_header_key.'\'); ?>';
	}
	else
	{
		$add_form_header_key = 'Add '.$object_name;
		$add_form_header_key = ucwords($add_form_header_key);
	}

	return $add_form_header_key;
}

function generate_edit_form_header_key($object_name,$use_lang=TRUE)
{
	$object_name = strtolower($object_name);
	$object_name = str_replace(' ', '_', $object_name);

	if($use_lang)
	{
		$edit_form_header_key = 'edit_'.$object_name.'_header';
		$edit_form_header_key = '<?php echo $this->lang->line(\''.$edit_form_header_key.'\'); ?>';
	}
	else
	{
		$edit_form_header_key = 'Edit '.$object_name;
		$edit_form_header_key = ucwords($edit_form_header_key);
	}

	return $edit_form_header_key;
}

function generate_form_label_key($form_label,$use_lang=TRUE)
{
	if($use_lang)
	{
		$form_label = strtolower($form_label);
		$form_label = str_replace(' ', '_', $form_label);
		$form_label_key = '<?php echo $this->lang->line(\''.$form_label.'\'); ?>';
	}
	else
	{
		$form_label_key = trim($form_label);
	}

	return $form_label_key;
}

function generate_form_validation_label($form_label,$use_lang=TRUE)
{
	if($use_lang)
	{
		$form_label = strtolower($form_label);
		$form_label = str_replace(' ', '_', $form_label);
		$form_validation_label = '$this->lang->line(\''.$form_label.'\')';
	}
	else
	{
		$form_label = '\''.$form_label.'\'';
		$form_validation_label = trim($form_label);
	}

	return $form_validation_label;
}

function generate_lang_key($form_label)
{
	$original_form_label = $form_label;
	$form_label = strtolower($form_label);
	$form_label = str_replace(' ', '_', $form_label);
	$lang_key = '$lang[\''.$form_label.'\'] = \''.$original_form_label.'\';';

	return $lang_key;
}

function generate_lang_success_key($object_name,$type)
{
	if($type=='add_success')
	{
		$start_key = 'success_add_';
		$end_message = ' info have been successfully added';
	}
	else if($type=='edit_success')
	{
		$start_key = 'success_edit_';
		$end_message = ' info have been successfully updated';
	}
	else if($type=='delete_success')
	{
		$start_key = 'success_delete_';
		$end_message = ' info have been successfully deleted';
	}

	$object_name = strtolower($object_name);
	$object_name = str_replace(' ', '_', $object_name);
	$message_key = $start_key.$object_name;
	$message = 'The '.$object_name.$end_message;

	$success_lang_key = '$lang[\''.$message_key.'\'] = \''.$message.'\';';

	return $success_lang_key;
}

function generate_lang_message_key($object_name,$type,$use_lang=TRUE)
{
	if($type=='add_success')
	{
		$start_key = 'success_add_';
		$end_message = ' info have been successfully added';
	}
	else if($type=='edit_success')
	{
		$start_key = 'success_edit_';
		$end_message = ' info have been successfully updated';
	}
	else if($type=='delete_success')
	{
		$start_key = 'success_delete_';
		$end_message = ' info have been successfully deleted';
	}

	if($use_lang)
	{
		$object_name = strtolower($object_name);
		$object_name = str_replace(' ', '_', $object_name);
		$message_key = $start_key.$object_name;
		$message = '$this->lang->line(\''.$message_key.'\')';
	}
	else
	{
		$message = '\'The '.$object_name.$end_message.'\'';
	}

	return $message;
}

function generate_form_dropdown_default_key($form_label,$use_lang=TRUE)
{
	if($use_lang)
	{
		$form_label = strtolower($form_label);
		$form_label = str_replace(' ', '_', $form_label);
		$dropdown_default_key = 'select_'.$form_label;
		$dropdown_default_key = '<?php echo $this->lang->line(\''.$dropdown_default_key.'\'); ?>';
	}
	else
	{
		$dropdown_default_key = 'Select '.$form_label;
	}

	return $dropdown_default_key;
}

?>