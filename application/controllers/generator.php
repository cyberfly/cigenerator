<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generator extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('video_model');
        $this->use_lang = FALSE; //if set to true, it will use lang file instead of harcode the form label
        $this->use_gebo = FALSE; //if set to true, it will use gebo style for template
        $this->save_button_label = generate_button_key('save',$this->use_lang);
        $this->save_change_button_label = generate_button_key('save_change',$this->use_lang);
        $this->cancel_button_label = generate_button_key('cancel',$this->use_lang);
    }

    public function index()
	{
		$data = array();

		$data['table_records'] = $this->db->list_tables();

		$data['main'] = 'generator/generate_view';
		$data['no_sidebar'] = 'Y';

		$this->load->view('template/template',$data);
	}

	public function step_2()
	{
		$table_name = $this->input->post('table_name');

		$exp_result = explode("_", $table_name);

        if(isset($exp_result[1]))
        {
        	$object_name = $exp_result[1];
        }
        else
        {
        	$object_name = $table_name;
        }

        if(isset($exp_result[2]))
        {
        	$object_name = $exp_result[1].'_'.$exp_result[2];
        }

        $controller_name = ucfirst($object_name);
        $model_name = ucfirst($object_name).'_model';

		$data = array();

		$data['table_name'] = $table_name;
		$data['controller_name'] = $controller_name;
		$data['model_name'] = $model_name;
		$data['object_name'] = $object_name;
		$data['table_records'] = $this->db->list_tables();
		$data['table_fields'] = $this->db->list_fields($table_name);

		$data['main'] = 'generator/generate_view_2';
		$data['no_sidebar'] = 'Y';

		$this->load->view('template/template',$data);
	}

	public function generate_it()
	{
		$this->object_name = $this->input->post('object_name');
		$this->object_index = strtolower($this->object_name);
		$this->object_id = $this->object_name.'_id';
		$this->object_id_var = '$'.$this->object_name.'_id';
		$this->model_name = strtolower($this->input->post('model_name'));
		$this->controller_name = strtolower($this->input->post('controller_name'));
		$this->table_name = $this->input->post('table_name');
		$this->object_records = '$'.strtolower($this->object_name).'_records';

		$this->selected_attribute = $this->input->post('selected_attribute');

		//var_dump($this->controller_name);exit;

		//$model = $this->build_model();
		$model = $this->build_MY_model();
		$controller = $this->build_controller();
		$add_view = $this->build_add_view();
		$edit_view = $this->build_edit_view();
		$list_view = $this->build_list_view();
		$list_js = $this->build_list_js();
		$lang_view = $this->build_lang();
		$initial_data_view = $this->build_initial_data();

		$this->load->helper('file');
		$this->load->helper('date');

		$this->folder_name = now();
		$this->build_path = './builds/'.$this->folder_name.'/';
		$this->model_file_name = strtolower($this->model_name).'.php';
		$this->controller_file_name = strtolower($this->controller_name).'.php';
		$this->add_view_file_name = strtolower('add'.'_'.$this->object_name).'.php';
		$this->edit_view_file_name = strtolower('edit'.'_'.$this->object_name).'.php';
		$this->list_view_file_name = strtolower($this->object_name.'_list').'.php';
		$this->list_js_file_name = strtolower($this->object_name.'_list').'.js';
		$this->lang_file_name = strtolower($this->object_name.'_lang').'.php';
		$this->initial_file_name = strtolower($this->object_name.'_records').'.php';

		//create the folder first

		mkdir('./builds/' . $this->folder_name);

		//write the model

		if ( ! write_file($this->build_path.$this->model_file_name, $model))
		{
		     $model_content = 'Unable to write the file';
		}
		else
		{
		     // echo 'model written!';
			$model_content = read_file($this->build_path.$this->model_file_name);
		}

		//write the controller

		if ( ! write_file($this->build_path.$this->controller_file_name, $controller))
		{
		     $controller_content = 'Unable to write the file';
		}
		else
		{
		     // echo 'controller written!';
			$controller_content = read_file($this->build_path.$this->controller_file_name);
		}

		//write the add view

		if ( ! write_file($this->build_path.$this->add_view_file_name, $add_view))
		{
		     $add_content = 'Unable to write the file';
		}
		else
		{
		     // echo 'add view written!';
		     $add_content = read_file($this->build_path.$this->add_view_file_name);
		}

		//write the edit view

		if ( ! write_file($this->build_path.$this->edit_view_file_name, $edit_view))
		{
		     $edit_content = 'Unable to write the file';
		}
		else
		{
		     // echo 'edit view written!';
		     $edit_content = read_file($this->build_path.$this->edit_view_file_name);
		}

		//write the list view

		if ( ! write_file($this->build_path.$this->list_view_file_name, $list_view))
		{
		     $list_content = 'Unable to write the file';
		}
		else
		{
		     // echo 'list view written!';
		     $list_content = read_file($this->build_path.$this->list_view_file_name);
		}

		//write the javascript for object list

		if ( ! write_file($this->build_path.$this->list_js_file_name, $list_js))
		{
		     $js_content = 'Unable to write the file';
		}
		else
		{
		     // echo 'list js written!';
		     $js_content = read_file($this->build_path.$this->list_js_file_name);
		}

		//write the language file

		if ( ! write_file($this->build_path.$this->lang_file_name, $lang_view))
		{
		     $lang_content = 'Unable to write the file';
		}
		else
		{
		     // echo 'list js written!';
		     $lang_content = read_file($this->build_path.$this->lang_file_name);
		}

		//write the initial records

		if ( ! write_file($this->build_path.$this->initial_file_name, $initial_data_view))
		{
		     $object_content = 'Unable to write the file';
		}
		else
		{
		     // echo 'list js written!';
		     $object_content = read_file($this->build_path.$this->initial_file_name);
		}

		$controller_content = htmlentities($controller_content);
		$model_content = htmlentities($model_content);
		$add_content = htmlentities($add_content);
		$edit_content = htmlentities($edit_content);
		$list_content = htmlentities($list_content);
		$js_content = htmlentities($js_content);
		$lang_content = htmlentities($lang_content);
		$object_content = htmlentities($object_content);

		$data['controller_content'] = $controller_content;
		$data['model_content'] = $model_content;
		$data['add_content'] = $add_content;
		$data['edit_content'] = $edit_content;
		$data['list_content'] = $list_content;
		$data['js_content'] = $js_content;
		$data['lang_content'] = $lang_content;
		$data['object_content'] = $object_content;
		$data['main'] = 'generator/result';
		$data['no_sidebar'] = 'Y';

		$this->load->view('template/template',$data);

	}

	public function build_MY_model()
	{
		$model = '<?php

class '.ucfirst($this->model_name).' extends MY_Model {

	protected $_table = \''.$this->table_name.'\';
	protected $primary_key = \''.$this->object_id.'\';

	public function '.$this->object_name.'_info()
    {';

    	foreach($this->selected_attribute as $key => $value)
		{
			//if join the table

			if($this->input->post("foreign_key_$key"))
			{
				$join_table_id =  $this->input->post("foreign_key_$key");
				$exp = explode(".", $join_table_id);
				$join_table = $exp[0];
				$current_table_id = $this->table_name.'.'.$exp[1];

				$model .= '
        $this->db->join(\''.$join_table.'\', \''.$join_table_id.' = '.$current_table_id.'\');';
			}
    	}

    $model .= '

        $this->db->select(\'*\');

        return $this;
    }

}
?>';
		return $model;
	}

	public function build_model()
	{
		$model = '<?php

class '.ucfirst($this->model_name).' extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function add_'.$this->object_name.'($form_data)
	{
		$insert = $this->db->insert(\''.$this->table_name.'\', $form_data);

		return $insert;
	}

	function edit_'.$this->object_name.'($form_data,'.$this->object_id_var.')
	{
		$insert = $this->db->insert(\''.$this->table_name.'\', $form_data);

		return $insert;
	}

	function delete_'.$this->object_name.'('.$this->object_id_var.')
	{
		$this->db->where(\''.$this->object_id.'\', '.$this->object_id_var.');
		$delete = $this->db->delete(\''.$this->table_name.'\');
		return $delete;
	}

	function validate_'.$this->object_name.'_name('.$this->object_name.'_name,'.$this->object_id_var.')
	{
		$this->db->where(\''.$this->object_name.'_name\', '.$this->object_name.');
		$this->db->where(\''.$this->object_id.'!=\', '.$this->object_id_var.');

		$query = $this->db->get(\''.$this->table_name.'\');

		if($query->num_rows !=0)
		{
			return false;
		}

		return true;
	}



}
?>';
		return $model;
	}

	public function build_controller()
	{
		$controller = '<?php

class '.ucfirst($this->controller_name).' extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(\''.$this->object_name.'_model\');
	}

	function index()
	{
		$data = array();

		$'.$this->object_name.'_records = $this->'.$this->object_name.'_model->'.$this->object_name.'_info()->get_all();

		$data[\''.$this->object_name.'_records\'] = $'.$this->object_name.'_records;

	    $data[\'main\'] = \''.$this->object_name.'/'.$this->object_name.'_list\';
	    $data[\'js_function\'] = array(\''.$this->object_name.'_list\');

		$this->load->view(\'template/template\',$data);
	}

	function add_'.$this->object_name.'()
	{
		$this->load->library(\'form_validation\');
		';

		foreach($this->selected_attribute as $key => $value)
		{
			//generate the validation rules

			$validation_rules = '';

			//if the attribute have validation rules only we process it

			if($this->input->post("input_validation_$key"))
			{
				foreach($this->input->post("input_validation_$key") as $row)
				{
					$validation_rules .= $row.'|';
				}
			}

			$form_label = $this->input->post("form_label_$key");
			$form_validation_label = generate_form_validation_label($form_label,$this->use_lang);

			if(!empty($validation_rules) && $this->input->post("show_in_form_$key"))
			{
				$validation_rules = rtrim($validation_rules,'|');
				$controller .='$this->form_validation->set_rules(\''.$value.'\', '.$form_validation_label.', \''.$validation_rules.'\');'. "\n\t\t";
			}

		}

		//build the data array to insert into database

		$data_string = '';

		foreach($this->selected_attribute as $key => $value)
		{
			$data_string .= "'$value'=>\$$value,";
		}

		//remove the first and last single quote and the last comma in the array

		if(!empty($data_string))
		{
			$data_string = rtrim($data_string,',');
		}

		$controller .='

		if($this->form_validation->run() == TRUE)
	    {
	    	';

		//build the variable from post

		foreach($this->selected_attribute as $key => $value)
		{
			$controller .='$'.$value.' = $this->input->post(\''.$value.'\');'. "\n\t\t\t";
		}

	    $controller .='

	    	$data = array('.$data_string.');

	    	if($this->'.$this->object_name.'_model->insert($data))
			{
				$this->session->set_flashdata(\'success\', '.generate_lang_message_key($this->object_name,'add_success',$this->use_lang).');
				redirect(\''.$this->object_name.'/add_'.$this->object_name.'\');
			}
			else
			{
				$this->session->set_flashdata(\'error\', \'Error. Please try again.\');
				redirect(\''.$this->object_name.'/add_'.$this->object_name.'\');
			}
	    }
	    else //if page initial load or form validation false
	    {
	    	$data = array();'. "\n\n\t\t\t";

	   	foreach($this->selected_attribute as $key => $value)
		{
			//if we got dynamic input, we load from database the records

			if($this->input->post("show_in_form_$key") && preg_match("/dynamic/i", $this->input->post("input_type_$key")) )
			{
				$join_table_id =  $this->input->post("foreign_key_$key");
				$exp = explode(".", $join_table_id);
				$join_table = $exp[0];

				//remove the tb_ from table name and concate with records and model

				$foreign_object = str_replace('tb_', '', $join_table);

				//$controller .= '$'.$foreign_object.'_records = $this->'.$foreign_object.'_model->get_many_by(\'user_id\',$this->user_id);'. "\n\t\t\t";
				$controller .= '$'.$foreign_object.'_records = $this->'.$foreign_object.'_model->get_all();'. "\n\t\t\t";
				$controller .= '$data[\''.$foreign_object.'_records\'] = $'.$foreign_object.'_records;'. "\n\n\t\t\t";
			}
		}

	    $controller .= '

	    	$data[\'main\'] = \''.$this->object_name.'/add_'.$this->object_name.'\';

			$this->load->view(\'templates/template\',$data);
	    }
	}

	function edit_'.$this->object_name.'()
	{
		$this->load->library(\'form_validation\');
		';

		foreach($this->selected_attribute as $key => $value)
		{
			//generate the validation rules

			$validation_rules = '';

			//if the attribute have validation rules only we process it

			if($this->input->post("input_validation_$key"))
			{
				foreach($this->input->post("input_validation_$key") as $row)
				{
					$validation_rules .= $row.'|';
				}
			}

			$form_label = $this->input->post("form_label_$key");
			$form_validation_label = generate_form_validation_label($form_label,$this->use_lang);

			if(!empty($validation_rules) && $this->input->post("show_in_form_$key"))
			{
				$validation_rules = rtrim($validation_rules,'|');
				$controller .='$this->form_validation->set_rules(\''.$value.'\', '.$form_validation_label.', \''.$validation_rules.'\');'. "\n\t\t";
			}

		}

		//build the data array to insert into database

		$data_string = '';

		foreach($this->selected_attribute as $key => $value)
		{
			$data_string .= "'$value'=>\$$value,";
		}

		//remove the first and last single quote and the last comma in the array

		if(!empty($data_string))
		{
			$data_string = rtrim($data_string,',');
		}

		$controller .='

		if($this->form_validation->run() == TRUE)
	    {
	    	$hash_'.$this->object_name.'_id = $this->input->post(\''.$this->object_id.'\');

	    	//check hash if the user edit it

	    	'.$this->object_id_var.' = get_attr_id($hash_'.$this->object_id.');
	    	$hash = get_attr_hash($hash_'.$this->object_id.');

	    	$this->permission->check_form_id_hash('.$this->object_id_var.',$hash);

	    	';

		//build the variable from post

		foreach($this->selected_attribute as $key => $value)
		{
			$controller .='$'.$value.' = $this->input->post(\''.$value.'\');'. "\n\t\t\t";
		}

	    $controller .='

	    	$data = array('.$data_string.');

	    	if($this->'.$this->object_name.'_model->update('.$this->object_id_var.',$data))
			{
				$this->session->set_flashdata(\'success\', \'The '.$this->object_name.' info have been successfully updated\');
				redirect("'.$this->object_name.'/edit_'.$this->object_name.'/'.$this->object_id_var.'/$hash");
			}
			else
			{
				$this->session->set_flashdata(\'error\', \'Error. Please try again.\');
				redirect("'.$this->object_name.'/edit_'.$this->object_name.'/'.$this->object_id_var.'/$hash");
			}
	    }
	    else //if page initial load or form validation false
	    {
	    	'.$this->object_id_var.' = $this->uri->segment(3);

	    	//means come from '.$this->object_name.' list

	    	if($this->uri->segment(3))
	    	{
	    		$this->permission->check_id_hash('.$this->object_id_var.');
	    	}

	    	//means come from validation error

	    	if($this->input->post(\''.$this->object_id.'\'))
	    	{
	    		$hash_'.$this->object_name.'_id = $this->input->post(\''.$this->object_id.'\');

		    	//check hash if the user edit it

		    	'.$this->object_id_var.' = get_attr_id($hash_'.$this->object_id.');
		    	$hash = get_attr_hash($hash_'.$this->object_id.');

		    	$this->permission->check_form_id_hash('.$this->object_id_var.',$hash);
	    	}

	    	$data = array();'. "\n\n\t\t\t";

	   	foreach($this->selected_attribute as $key => $value)
		{
			//if we got dynamic input, we load from database the records

			if($this->input->post("show_in_form_$key") && preg_match("/dynamic/i", $this->input->post("input_type_$key")) )
			{
				$join_table_id =  $this->input->post("foreign_key_$key");
				$exp = explode(".", $join_table_id);
				$join_table = $exp[0];

				//remove the tb_ from table name and concate with records and model

				$foreign_object = str_replace('tb_', '', $join_table);

				$controller .= '$'.$foreign_object.'_records = $this->'.$foreign_object.'_model->get_all();'. "\n\t\t\t";
				$controller .= '$data[\''.$foreign_object.'_records\'] = $'.$foreign_object.'_records;'. "\n\n\t\t\t";
			}
		}

	    $controller .= '

	    	'.$this->object_records.' = $this->'.$this->model_name.'->get('.$this->object_id_var.');

	    	$data[\''.$this->object_name.'_records\'] = '.$this->object_records.';

	    	$data[\'main\'] = \''.$this->object_name.'/edit_'.$this->object_name.'\';

			$this->load->view(\'templates/template\',$data);
	    }
	}

	function ajax_delete_'.$this->object_name.'()
	{
		$this->permission->is_ajax();

		$ajax_'.$this->object_id.' = $this->input->post(\''.$this->object_id.'\');

		//get the '.$this->object_id.'

		'.$this->object_id_var.' = get_attr_id($ajax_'.$this->object_id.');

		//get the hash

		$hash = get_attr_hash($ajax_'.$this->object_id.');

		//check the hash

		$this->permission->check_ajax_id_hash('.$this->object_id_var.',$hash);

		if($this->'.$this->object_name.'_model->delete('.$this->object_id_var.'))
		{
			echo \'1\';
		}
		else
		{
			echo \'2\';
		}

	}

}
?>';
		return $controller;
	}

	public function build_add_view()
	{
		$add_form_header_key = generate_add_form_header_key($this->object_name,$this->use_lang);

		$add_view = '

	<div class="row-fluid">
		<div class="span12">
			<h3 class="heading">'.$add_form_header_key.'</h3>
				<div class="row-fluid">
					<div class="span8">
						<form class="form-horizontal" action="<?php echo site_url(\''.$this->controller_name.'/add_'.$this->object_name.'\'); ?>" method="post" >
							<fieldset>
		';

    	foreach($this->selected_attribute as $key => $value)
		{
			$form_label = $this->input->post("form_label_$key");
			$form_label_key = generate_form_label_key($form_label,$this->use_lang);

			$dynamic_records = $value.'_records';
			$dynamic_records = str_replace('_id_', '_', $dynamic_records);

			$validation_rules = array();

			//if the attribute have validation rules only we process it

			if($this->input->post("input_validation_$key"))
			{
				foreach($this->input->post("input_validation_$key") as $row)
				{
					$validation_rules[] = $row;
				}
			}

			$required_symbol = '';

			if(in_array('required', $validation_rules))
			{
				$required_symbol = '<span class="f_req">*</span>';
			}

			//if show in form

			if($this->input->post("show_in_form_$key"))
			{
				$add_view .= '
								<?php $error = \'\'; if(form_error(\''.$value.'\')){ $error = \'error\'; } ?>

							   	<div class="control-group formSep <?php echo $error; ?>">
							        <label for="select01" class="control-label">'.$form_label_key.' '.$required_symbol.'</label>
							        <div class="controls">';

				if($this->input->post("input_type_$key")=='dynamic_dropdown')
				{
					$foreign_key = $this->input->post("foreign_relationship_$key");
					$dropdown_default_key = generate_form_dropdown_default_key($form_label,$this->use_lang);

					$add_view .= '
									    <select name="'.$value.'" id="'.$value.'" class="input-xlarge chosen">
							                <option value="">'.$dropdown_default_key.'</option>
							                <?php if(isset($'.$dynamic_records.')) : foreach($'.$dynamic_records.' as $row) : ?>
											<option value="<?php echo $row->'.$value.'; ?>" <?php echo set_select(\''.$value.'\', $row->'.$value.'); ?>  >
											<?php echo $row->'.$foreign_key.'; ?></option>
											<?php endforeach; ?>
											<?php endif; ?>
							            </select>';

				}
				else if($this->input->post("input_type_$key")=='dropdown')
				{
					$dropdown_default_key = generate_form_dropdown_default_key($form_label,$this->use_lang);
					$input_option = $this->input->post("input_option_$key");

					$option_array = $this->construct_option_array($input_option);

					$add_view .= '
									    <select name="'.$value.'" id="'.$value.'" class="input-xlarge chosen">
							                <option value="">'.$dropdown_default_key.'</option>';

							 if(!empty($option_array))
							 {
							 	foreach($option_array as $opt_key => $opt_val)
							 	{
							 		$add_view .= '
							 				<option value="'.$opt_key.'" <?php echo set_select(\''.$value.'\', \''.$opt_key.'\'); ?> >'.$opt_val.'</option>';
							 	}
							 }

					$add_view .= '
									    </select>';

				}
				else if($this->input->post("input_type_$key")=='dynamic_checkbox')
				{
					$foreign_key = $this->input->post("foreign_relationship_$key");

					$add_view .= '
									    <?php if(isset($'.$dynamic_records.')) : foreach($'.$dynamic_records.' as $row) : ?>
									    <label class="checkbox">
											<input type="checkbox" name="'.$value.'[]" value="<?php echo $row->'.$value.'; ?>" <?php echo set_checkbox(\''.$value.'[]\', $row->'.$value.'); ?> >
											<?php echo $row->'.$foreign_key.'; ?>
										</label>
										<?php endforeach; ?>
										<?php endif; ?>';

				}
				else if($this->input->post("input_type_$key")=='checkbox')
				{
					$input_option = $this->input->post("input_option_$key");

					$option_array = $this->construct_option_array($input_option);

					if(!empty($option_array))
					{
					 	foreach($option_array as $opt_key => $opt_val)
					 	{
							if(sizeof($option_array)>1)
							{
								$add_view .= '
										<label class="checkbox">
											<input type="checkbox" name="'.$value.'[]" value="'.$opt_key.'" <?php echo set_checkbox(\''.$value.'[]\', \''.$opt_key.'\'); ?> >
											'.$opt_val.'
										</label>';
							}
							else
							{
								$add_view .= '
										<label class="checkbox">
											<input type="checkbox" name="'.$value.'" value="'.$opt_key.'" <?php echo set_checkbox(\''.$value.'\', \''.$opt_key.'\'); ?> >
											'.$opt_val.'
										</label>';
							}
					 	}
					}
				}
				else if($this->input->post("input_type_$key")=='dynamic_radio')
				{
					$foreign_key = $this->input->post("foreign_relationship_$key");

					$add_view .= '
									    <?php if(isset($'.$dynamic_records.')) : foreach($'.$dynamic_records.' as $row) : ?>
									    <label class="radio">
											<input type="radio" name="'.$value.'" id="'.$value.'" value="<?php echo $row->'.$value.'; ?>" <?php echo set_radio(\''.$value.'\', $row->'.$value.'); ?> >
											<?php echo $row->'.$foreign_key.'; ?>
										</label>
										<?php endforeach; ?>
										<?php endif; ?>';

				}
				else if($this->input->post("input_type_$key")=='radio')
				{
					$input_option = $this->input->post("input_option_$key");

					$option_array = $this->construct_option_array($input_option);

					if(!empty($option_array))
					{
					 	foreach($option_array as $opt_key => $opt_val)
					 	{
							$add_view .= '
										<label class="radio">
											<input type="radio" name="'.$value.'" value="'.$opt_key.'" <?php echo set_radio(\''.$value.'\', \''.$opt_key.'\'); ?> >
											'.$opt_val.'
										</label>';
					 	}
					}

				}
				else if($this->input->post("input_type_$key")=='text')
				{
					$add_view .= '
										<input type="text" name="'.$value.'" id="'.$value.'" value="<?php echo set_value(\''.$value.'\'); ?>" class="input-xlarge"  >';

				}
				else if($this->input->post("input_type_$key")=='date')
				{
					$add_view .= '
										<div class="input-append date form_date" data-date-format="dd-mm-yyyy">
											<input class="input-xlarge" type="text" name="'.$value.'" id="'.$value.'" value="<?php echo set_value(\''.$value.'\'); ?>" /><span class="add-on"><i class="icon-calendar"></i></span>
										</div>';

				}
				else if($this->input->post("input_type_$key")=='textarea')
				{
					$add_view .= '
										<textarea class="span8" rows="3" cols="10" id="'.$value.'" name="'.$value.'"><?php echo set_value(\''.$value.'\'); ?></textarea>';

				}

				$add_view .= '
										<?php echo form_error(\''.$value.'\', \'<span class="help-inline">\', \'</span>\'); ?>
									</div>
							  	</div>
							  	';

			}

		}

			$add_view .= '
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-gebo" type="submit">'.$this->save_button_label.'</button>
										<a class="btn" href="<?php echo site_url(\''.$this->controller_name.'\'); ?>">'.$this->cancel_button_label.'</a>
									</div>
								</div>

								</fieldset>
							</form>
					</div>
				</div>
			</div>
		</div>';

		return  $add_view;
	}

	public function build_edit_view()
	{
		$edit_form_header_key = generate_edit_form_header_key($this->object_name,$this->use_lang);

		$edit_view = '

	<div class="row-fluid">
		<div class="span12">
			<h3 class="heading">'.$edit_form_header_key.'</h3>
				<div class="row-fluid">
					<div class="span8">
						<form class="form-horizontal" action="<?php echo site_url(\''.$this->controller_name.'/edit_'.$this->object_name.'\'); ?>" method="post" >
							<fieldset>
		';

    	foreach($this->selected_attribute as $key => $value)
		{
			$form_label = $this->input->post("form_label_$key");
			$form_label_key = generate_form_label_key($form_label,$this->use_lang);

			$dynamic_records = $value.'_records';
			$dynamic_records = str_replace('_id_', '_', $dynamic_records);

			$validation_rules = array();

			//if the attribute have validation rules only we process it

			if($this->input->post("input_validation_$key"))
			{
				foreach($this->input->post("input_validation_$key") as $row)
				{
					$validation_rules[] = $row;
				}
			}

			$required_symbol = '';

			if(in_array('required', $validation_rules))
			{
				$required_symbol = '<span class="f_req">*</span>';
			}

			//if show in form

			if($this->input->post("show_in_form_$key"))
			{
				//build the database records key

				$records_key = $this->object_records.'->'.$value;

				$edit_view .= '
								<?php $error = \'\'; if(form_error(\''.$value.'\')){ $error = \'error\'; } ?>

							   	<div class="control-group formSep <?php echo $error; ?>">
							        <label for="select01" class="control-label">'.$form_label_key.' '.$required_symbol.'</label>
							        <div class="controls">';

				if($this->input->post("input_type_$key")=='dynamic_dropdown')
				{
					$foreign_key = $this->input->post("foreign_relationship_$key");
					$dropdown_default_key = generate_form_dropdown_default_key($form_label,$this->use_lang);

					$edit_view .= '
									    <select name="'.$value.'" id="'.$value.'" class="input-xlarge chosen">
							                <option value="">'.$dropdown_default_key.'</option>
							                <?php if(isset($'.$dynamic_records.')) : foreach($'.$dynamic_records.' as $row) :
							                	$selected = FALSE; if('.$records_key.'==$row->'.$value.'){ $selected = TRUE; }
							                ?>
											<option value="<?php echo $row->'.$value.'; ?>" <?php echo set_select(\''.$value.'\', $row->'.$value.',$selected); ?>  >
											<?php echo $row->'.$foreign_key.'; ?></option>
											<?php endforeach; ?>
											<?php endif; ?>
							            </select>';

				}
				else if($this->input->post("input_type_$key")=='dropdown')
				{
					$dropdown_default_key = generate_form_dropdown_default_key($form_label,$this->use_lang);
					$input_option = $this->input->post("input_option_$key");

					$option_array = $this->construct_option_array($input_option);

					$edit_view .= '
										<?php';

					if(!empty($option_array))
					{
						foreach($option_array as $opt_key => $opt_val)
						{
							$selected_key = strtolower($opt_key);
							$selected_key = str_replace(' ', '_', $selected_key);
							$selected_key = $selected_key.'_selected';

							$edit_view .= '

											$'.$selected_key.' = FALSE;

											if('.$records_key.'==\''.$opt_key.'\'){ $'.$selected_key.' = TRUE; }';


						}
					}

					$edit_view .= '
										?>';

					$edit_view .= '
									    <select name="'.$value.'" id="'.$value.'" class="input-xlarge chosen">
							                <option value="">'.$dropdown_default_key.'</option>';

							 if(!empty($option_array))
							 {
							 	foreach($option_array as $opt_key => $opt_val)
							 	{
							 		$selected_key = strtolower($opt_key);
									$selected_key = str_replace(' ', '_', $selected_key);
									$selected_key = $selected_key.'_selected';

							 		$edit_view .= '
							 				<option value="'.$opt_key.'" <?php echo set_select(\''.$value.'\', \''.$opt_key.'\', $'.$selected_key.'); ?> >'.$opt_val.'</option>';
							 	}
							 }

					$edit_view .= '
									    </select>';

				}
				else if($this->input->post("input_type_$key")=='dynamic_checkbox')
				{
					$foreign_key = $this->input->post("foreign_relationship_$key");

					$edit_view .= '
									    <?php if(isset($'.$dynamic_records.')) : foreach($'.$dynamic_records.' as $row) :
									    	$checked = FALSE; if (in_array($row->'.$value.', $group_contact_records)) { $checked = TRUE; }
									    ?>
									    <label class="checkbox">
											<input type="checkbox" name="'.$value.'[]" value="<?php echo $row->'.$value.'; ?>" <?php echo set_checkbox(\''.$value.'[]\', $row->'.$value.', $checked); ?> >
											<?php echo $row->'.$foreign_key.'; ?>
										</label>
										<?php endforeach; ?>
										<?php endif; ?>';

				}
				else if($this->input->post("input_type_$key")=='checkbox')
				{
					$input_option = $this->input->post("input_option_$key");

					$option_array = $this->construct_option_array($input_option);

					$edit_view .= '
										<?php';

					if(!empty($option_array))
					{
						foreach($option_array as $opt_key => $opt_val)
						{
							$checked_key = strtolower($opt_key);
							$checked_key = str_replace(' ', '_', $checked_key);
							$checked_key = $checked_key.'_checked';

							$edit_view .= '

											$'.$checked_key.' = FALSE;

											if('.$records_key.'==\''.$opt_key.'\'){ $'.$checked_key.' = TRUE; }';


						}
					}

					$edit_view .= '
										?>';

					if(!empty($option_array))
					{
					 	foreach($option_array as $opt_key => $opt_val)
					 	{
							$checked_key = strtolower($opt_key);
							$checked_key = str_replace(' ', '_', $checked_key);
							$checked_key = $checked_key.'_checked';

							if(sizeof($option_array)>1)
							{
								$edit_view .= '
										<label class="checkbox">
											<input type="checkbox" name="'.$value.'[]" value="'.$opt_key.'" <?php echo set_checkbox(\''.$value.'[]\', \''.$opt_key.'\', $'.$checked_key.'); ?> >
											'.$opt_val.'
										</label>';
							}
							else
							{
								$edit_view .= '
										<label class="checkbox">
											<input type="checkbox" name="'.$value.'" value="'.$opt_key.'" <?php echo set_checkbox(\''.$value.'\', \''.$opt_key.'\', $'.$checked_key.'); ?> >
											'.$opt_val.'
										</label>';
							}
					 	}
					}
				}
				else if($this->input->post("input_type_$key")=='dynamic_radio')
				{
					$foreign_key = $this->input->post("foreign_relationship_$key");

					$edit_view .= '
									    <?php if(isset($'.$dynamic_records.')) : foreach($'.$dynamic_records.' as $row) :
									    	$checked = FALSE; if('.$records_key.'==$row->'.$value.'){ $checked = TRUE; }
									    ?>
									    <label class="radio">
											<input type="radio" name="'.$value.'" id="'.$value.'" value="<?php echo $row->'.$value.'; ?>" <?php echo set_radio(\''.$value.'\', $row->'.$value.', $checked); ?> >
											<?php echo $row->'.$foreign_key.'; ?>
										</label>
										<?php endforeach; ?>
										<?php endif; ?>';

				}
				else if($this->input->post("input_type_$key")=='radio')
				{
					$input_option = $this->input->post("input_option_$key");

					$option_array = $this->construct_option_array($input_option);

					$edit_view .= '
										<?php';

					if(!empty($option_array))
					{
						foreach($option_array as $opt_key => $opt_val)
						{
							$checked_key = strtolower($opt_key);
							$checked_key = str_replace(' ', '_', $checked_key);
							$checked_key = $checked_key.'_checked';

							$edit_view .= '

											$'.$checked_key.' = FALSE;

											if('.$records_key.'==\''.$opt_key.'\'){ $'.$checked_key.' = TRUE; }';


						}
					}

					$edit_view .= '
										?>';

					if(!empty($option_array))
					{
					 	foreach($option_array as $opt_key => $opt_val)
					 	{
							$checked_key = strtolower($opt_key);
							$checked_key = str_replace(' ', '_', $checked_key);
							$checked_key = $checked_key.'_checked';

							$edit_view .= '
										<label class="radio">
											<input type="radio" name="'.$value.'" value="'.$opt_key.'" <?php echo set_radio(\''.$value.'\', \''.$opt_key.'\', $'.$checked_key.'); ?> >
											'.$opt_val.'
										</label>';
					 	}
					}

				}
				else if($this->input->post("input_type_$key")=='text')
				{
					$edit_view .= '
										<input type="text" name="'.$value.'" id="'.$value.'" value="<?php echo set_value(\''.$value.'\','.$records_key.'); ?>" class="input-xlarge"  >';

				}
				else if($this->input->post("input_type_$key")=='date')
				{
					$edit_view .= '
										<div class="input-append date form_date" data-date-format="dd-mm-yyyy">
											<input class="input-xlarge" type="text" name="'.$value.'" id="'.$value.'" value="<?php echo set_value(\''.$value.'\',prepare_php_date('.$records_key.')); ?>" /><span class="add-on"><i class="icon-calendar"></i></span>
										</div>';

				}
				else if($this->input->post("input_type_$key")=='textarea')
				{
					$edit_view .= '
										<textarea class="span8" rows="3" cols="10" id="'.$value.'" name="'.$value.'"><?php echo set_value(\''.$value.'\','.$records_key.'); ?></textarea>';

				}

				$edit_view .= '
										<?php echo form_error(\''.$value.'\', \'<span class="help-inline">\', \'</span>\'); ?>
									</div>
							  	</div>
							  	';

			}

		}

			$edit_view .= '
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-gebo" type="submit">'.$this->save_change_button_label.'</button>
										<a class="btn" href="<?php echo site_url(\''.$this->controller_name.'\'); ?>">'.$this->cancel_button_label.'</a>
									</div>
								</div>

								<input type="hidden" name="'.$this->object_id.'" value="<?php echo encode_form_id('.$this->object_records.'->'.$this->object_id.'); ?>" />

								</fieldset>
							</form>
					</div>
				</div>
			</div>
		</div>';

		return  $edit_view;
	}

	public function build_list_view()
	{
		$list_view = '

	<div class="row-fluid">
		<div class="span12">
			<h3 class="heading">'.ucfirst($this->object_name).' List</h3>

				<div class="row-fluid">
					<div class="span12">
						<ul class="dshb_icoNav tac">
							<li><a href="<?php echo site_url(\''.$this->controller_name.'/add_'.$this->object_name.'\'); ?>" style="background-image: url(<?php echo base_url(); ?>assets/img/gCons/add-item.png)">New '.ucfirst($this->object_name).'</a></li>
						</ul>
					</div>
				</div>

				<table class="table table-striped table-bordered" id="dt_d">
                    <thead>
                        <tr>
                        	<th>No.</th>
                        ';

        foreach($this->selected_attribute as $key => $value)
		{
			$form_label = $this->input->post("form_label_$key");

			$list_view .= '	<th>'.$form_label.'</th>'. "\n\t\t\t\t\t\t";
		}

		$list_view .= "\t".'<th>Action</th>
						</tr>
                    </thead>
                    <tbody>
	                    <?php
						    $num = 0; if(isset('.$this->object_records.')) :foreach('.$this->object_records.' as $row): $num++;
						?>
						<tr>
							<td></td>'. "\n\t\t\t\t\t\t\t";

    	foreach($this->selected_attribute as $key => $value)
		{
	  		if($foreign_key = $this->input->post("foreign_relationship_$key"))
	  		{
	  			$td_value = $foreign_key;
	  		}
	  		else
	  		{
	  			$td_value = $value;
	  		}

	  		$list_view .='<td><?php echo $row->'.$td_value.'; ?></td>'. "\n\t\t\t\t\t\t\t";
		}

	$list_view .= 			'<td>
                              <a href="<?php echo site_url(\''.$this->controller_name.'/edit_'.$this->object_name.'/\'.$row->'.$this->object_id.'.\'/\'.encode_id($row->'.$this->object_id.')); ?>" class="sepV_a" title="Edit"><i class="icon-pencil"></i></a>
                              <a href="#" class="delete" id="<?php echo encode_ajax_id($row->'.$this->object_id.'); ?>" title="Delete"><i class="icon-trash"></i></a>
                          	</td>
                        </tr>
                        <?php endforeach; ?>
						<?php else : ?>
						<?php endif; ?>
                    </tbody>
            	</table>
      	</div>
 	</div>';

		return  $list_view;
	}

	public function build_list_js()
	{
		$list_js = '
	$(document).ready(function () {

		//delete

        $(".delete").click(function() {

          var ajax_id = $(this).attr(\'id\');
          var row = $(this).closest(\'tr\');

          apprise(\'Are you sure want to delete this '.$this->object_name.'?\', {\'verify\':true}, function(r)
          {
            if(r)
            {
                deleteAjax(ajax_id,row);
            }
            else
            {
                return false;
            }
          });

        });

        function deleteAjax(id,row)
        {
            $.ajax({
                type: "POST",
                url: config.base_url + \''.$this->controller_name.'/ajax_delete_'.$this->object_name.'\',
                dataType: \'text\',
                data : {
                    '.$this->object_id.' : id,
                },
                success : function(data) {
                    if(data==\'1\')
                    {
                        var oTable = $(\'#dt_d\').dataTable();

                        var pos = oTable.fnGetPosition(row.get(0));

                        oTable.fnDeleteRow(pos);

                        apprise(\'The '.$this->object_name.' has been deleted\');
                    }
                    else if(data==\'2\')
                    {
                        apprise(\'Error.\');
                    }
                    else
                    {
                        apprise(\'Error.\');
                    }
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
                }
            });
        }

	});

		';

		return  $list_js;
	}

	public function build_lang()
	{
		$lang_view = '<?php

';

    	foreach($this->selected_attribute as $key => $value)
		{
			$form_label = $this->input->post("form_label_$key");
			$lang_key = generate_lang_key($form_label);

			$lang_view .= $lang_key. "\n";
		}

		//lang for add, edit, delete success message

		$lang_view .= generate_lang_success_key($this->object_name,'add_success'). "\n";
		$lang_view .= generate_lang_success_key($this->object_name,'edit_success'). "\n";
		$lang_view .= generate_lang_success_key($this->object_name,'delete_success'). "\n";

		return  $lang_view;
	}

	//create default data, useful for first initial load of page

	public function build_initial_data()
	{
		$initial_data = '<?php

';
		$data_string = '';

		foreach($this->selected_attribute as $key => $value)
		{
			if($this->input->post("input_type_$key")=='date')
			{
				$default_value = '0000-00-00';
			}
			else
			{
				$default_value = '';
			}

			$data_string .= "'$value'=>'$default_value',";
		}

		//remove the first and last single quote and the last comma in the array

		if(!empty($data_string))
		{
			$data_string = rtrim($data_string,',');
		}

		$initial_data .= '$'.$this->object_name.'_records = array('.$data_string.');'. "\n";

		$initial_data .= '$'.$this->object_name.'_records = (object)$'.$this->object_name.'_records;';

		return  $initial_data;

	}

	function construct_option_array($input_option)
	{
		$option_array = array();

		if(!empty($input_option))
		{
			$exp_option = explode(',', $input_option);

			foreach($exp_option as $option_row)
			{
				$exp_option_row = explode('=>', $option_row);
				$option_key = $exp_option_row[0];
				$option_val = $exp_option_row[1];

				$option_array = $option_array + array($option_key=>$option_val);
			}
		}

		return $option_array;
	}

}

