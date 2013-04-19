

	<div class="page-header">
	<h1>Select Table (2 of 2) <small>Select table fields for View</small></h1>
	</div>

    <?php $this->load->view('template/show_error'); ?>

	<form class="form-vertical" method="post" action="<?php echo site_url('generator/generate_it'); ?>" enctype="multipart/form-data" >
    <fieldset>

    <div class="well">
    Table Name <input type="text" value="<?php echo $table_name; ?>" name="table_name" class="input-medium search-query">
    Controller Name <input type="text" value="<?php echo $controller_name; ?>" name="controller_name" class="input-medium search-query">
    Model Name <input type="text" value="<?php echo $model_name; ?>" name="model_name" class="input-medium search-query">
    <input type="hidden" name="object_name" value="<?php echo $object_name; ?>" />
    </div>

    <?php $index = 0; if(isset($table_fields)) : foreach($table_fields as $row) : $index++;

    $checked = 'checked="checked"';
    $input_type_name = 'input_type_'.$index;
    $input_option_name = 'input_option_'.$index;
    $input_validation_name = 'input_validation_'.$index.'[]';
    $input_type_checked = 'text';
    $foreign_table_name = '';
    $foreign_relationship = '';
    $foreign_relationship_label = '';

    if($index==1)
    {
        $checked = '';
    }

    //get the form label

    $form_label = $row;

    //remove the id

    $form_label = str_replace('_id', '', $form_label);

    //remove the underscore

    $form_label = str_replace('_', ' ', $form_label);

    $form_label = ucwords($form_label);


    //

    //check if dropdown that used data from diff db

    if(strpos($row, '_ID') || strpos($row, '_id'))
    {
        if($index!=1)
        {
            $input_type_checked = 'dynamic_dropdown';

            //get the table name

            $exp_result = explode("_", $row);

            $foreign_table_name = $exp_result[0];
            $foreign_table_name = strtolower($foreign_table_name);

            $foreign_relationship_label = $foreign_table_name.'_name';

            $foreign_table_name = 'tb_'.$foreign_table_name;
            $foreign_relationship = $foreign_table_name.'.'.$row;

        }
    }

    $selected_attribute_name  = "selected_attribute[$index]";
    $show_in_form_name  = "show_in_form_$index";
    $form_label_name  = "form_label_$index";
    $foreign_relationship_name = "foreign_relationship_$index";
    $foreign_key_name = "foreign_key_$index";

    ?>

    <h1><small><input type="checkbox" name="<?php echo $selected_attribute_name; ?>" value="<?php echo $row; ?>" <?php echo $checked; ?> /> <?php echo $row; ?> <input type="checkbox" name="<?php echo $show_in_form_name; ?>" value="<?php echo $row; ?>" <?php echo $checked; ?>  /> Show In Form <input type="text" name="<?php echo $form_label_name; ?>" value="<?php echo $form_label; ?>"/> </small></h1>
    <div class="row">
    <div class="span4 box">
    <h4>Input Type</h4>
    <div class="control-group">

        <div class="span2">

            <div class="controls">
              <label class="radio">
                <input type="radio" value="text" name="<?php echo $input_type_name; ?>" <?php if($input_type_checked=='text'){ ?> checked="checked" <?php } ?> >
                Text
              </label>
              <label class="radio">
                <input type="radio" value="dynamic_dropdown" name="<?php echo $input_type_name; ?>" <?php if($input_type_checked=='dynamic_dropdown'){ ?> checked="checked" <?php } ?> >
                Dynamic Dropdown
              </label>
              <label class="radio">
                <input type="radio" value="dynamic_checkbox" name="<?php echo $input_type_name; ?>" <?php if($input_type_checked=='dynamic_checkbox'){ ?> checked="checked" <?php } ?> >
                Dynamic Checkbox
              </label>
              <label class="radio">
                <input type="radio" value="dynamic_radio" name="<?php echo $input_type_name; ?>" <?php if($input_type_checked=='dynamic_radio'){ ?> checked="checked" <?php } ?> >
                Dynamic Radio
              </label>
            </div>
        </div>

        <div class="span1">

            <div class="controls">
              <label class="radio">
                <input type="radio" value="date" name="<?php echo $input_type_name; ?>"  >
                Date
              </label>
              <label class="radio">
                <input type="radio" value="dropdown" name="<?php echo $input_type_name; ?>" <?php if($input_type_checked=='dropdown'){ ?> checked="checked" <?php } ?> >
                Dropdown
              </label>
              <label class="radio">
                <input type="radio" value="checkbox" name="<?php echo $input_type_name; ?>" <?php if($input_type_checked=='checkbox'){ ?> checked="checked" <?php } ?> >
                Checkbox
              </label>
              <label class="radio">
                <input type="radio" value="radio" name="<?php echo $input_type_name; ?>" <?php if($input_type_checked=='radio'){ ?> checked="checked" <?php } ?> >
                Radio
              </label>
              <label class="radio">
                <input type="radio" value="textarea" name="<?php echo $input_type_name; ?>" <?php if($input_type_checked=='textarea'){ ?> checked="checked" <?php } ?> >
                TextArea
              </label>

            </div>
        </div>

    </div>

    </div>

    <div class="span4 box">
    <h4>Extras</h4>
    <div class="control-group">
        <div class="row">

          <div class="span2">
            <label>Key Relationship</label>
            <input type="text" name="<?php echo $foreign_relationship_name; ?>" value="<?php echo $foreign_relationship_label; ?>" class="input-small">
          </div>

          <div class="span2">
            <label>Foreign Key</label>
            <input type="text" name="<?php echo $foreign_key_name; ?>" value="<?php echo $foreign_relationship; ?>" class="input-medium">
          </div>

        </div>
        <div class="row">

          <div class="span4">
            <label>Dropdown/Checkbox/Radio Option (comma separate)</label>
            <textarea name="<?php echo $input_option_name; ?>" id="<?php echo $input_option_name; ?>" >K=>V,A=>B</textarea>
          </div>

        </div>
    </div>
    </div>

    <div class="span4 box">
    <h4>Validation Rules</h4>

        <div class="span2">

            <div class="control-group">
            <div class="controls">
              <label class="checkbox">
                <input type="checkbox" value="trim" name="<?php echo $input_validation_name; ?>" checked="checked" >
                trim
              </label>
              <label class="checkbox">
                <input type="checkbox" value="required" name="<?php echo $input_validation_name; ?>" >
                required
              </label>
              <label class="checkbox">
                <input type="checkbox" value="alpha" name="<?php echo $input_validation_name; ?>" >
                alpha
              </label>
              <label class="checkbox">
                <input type="checkbox" value="numeric" name="<?php echo $input_validation_name; ?>" >
                numeric
              </label>
              </div>
        </div>

        </div>

        <div class="span1">

            <div class="control-group">
            <div class="controls">
              <label class="checkbox">
                <input type="checkbox" value="alpha_numeric" name="<?php echo $input_validation_name; ?>" >
                alpha_numeric
              </label>
              <label class="checkbox">
                <input type="checkbox" value="alpha_dash" name="<?php echo $input_validation_name; ?>" >
                alpha_dash
              </label>
              <label class="checkbox">
                <input type="checkbox" value="is_unique" name="<?php echo $input_validation_name; ?>" >
                is_unique
              </label>
              <label class="checkbox">
                <input type="checkbox" value="valid_email" name="<?php echo $input_validation_name; ?>" >
                valid_email
              </label>
              </div>
        </div>

        </div>

    </div>
    </div>

    <br/>

    <?php endforeach; ?>
    <?php endif; ?>

    <div class="form-actions">
            <input type="submit" class="btn btn-primary" value="Generate It!">
            <a class="btn" href="<?php echo site_url('generator/index'); ?>">Cancel</a>
    </div>

    </fieldset>
    </form>




