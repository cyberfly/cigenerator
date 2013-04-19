<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image_convert  {

	private $_ci;

	public function __construct($params = array())
    {
       	$this->_ci = &get_instance();

        $this->_ci->load->library('image_lib');
        $this->_ci->load->helper('directory');
        $this->default_source_folder = '/ftp_test_upload/';
        $this->default_destination_folder = '/ftp_test_upload/sample/';
		$this->resize_array = array(
									array('width'=>200,'height'=>100),
									array('width'=>300,'height'=>100),
									array('width'=>400,'height'=>100),
									array('width'=>500,'height'=>100)
								 );

    }

    public function generate_thumbnail($resize_array=null, $data=null,$params = array())
    {

		$this->source_folder = (empty($params['source_folder'])) ? $this->default_source_folder : $params['source_folder'];
		$this->destination_folder = (empty($params['destination_folder'])) ? $this->default_destination_folder : $params['destination_folder'];
		$type = $params['type'];

    	$publisher_id = $data['publisher_id'];
    	$publisher_folder = $this->hash_publisher_id($publisher_id);

		$filename = $data['filename'];
    	$filename = $this->source_folder.$filename;
    	$img_link_hash = $data['img_link_hash'];

    	//default config

    	$config['image_library'] = 'gd2';
		$config['maintain_ratio'] = TRUE;
		$config['master_dim'] = 'width';
		$config['quality'] = '80%';
		
		if (!isset($resize_array)){
			$resize_array = $this->resize_array;
		}
		
		foreach($resize_array as $size)
		{
			$width = $size['width'];
			$height = $size['height'];

			$folder_size_name = $width.'x'.$height;

			$resize_folder = $this->destination_folder.$folder_size_name.'/';

			//create the resize folder

	    	if(!is_dir($resize_folder)){
			    mkdir($resize_folder);
			}

			$destination_folder = $this->destination_folder.$folder_size_name.'/'.$publisher_folder.'/';

	    	//create the destination folder

	    	if(!is_dir($destination_folder)){
			    mkdir($destination_folder);
			}

			$new_filename = $destination_folder.$img_link_hash.'_'.$type.'.png';

			//set the source file name and the destination name

    		$config['source_image'] = $filename;
			$config['new_image'] = $new_filename;

			$config['width'] = $width;
			$config['height'] = $height;

			//resize the file

    		$this->_ci->image_lib->initialize($config);
			$this->_ci->image_lib->resize();

			//display error

			echo $this->_ci->image_lib->display_errors();
		}

		echo 'success';

    }

    private function hash_publisher_id($publisher_id)
    {
    	$hash = sha1($publisher_id.SECRET_GENERAL_SALT);
    	$hash = substr($hash,4,6);

    	return $hash;
    }

    public function generate_bulk_thumbnail()
    {
    	$map = directory_map($this->source_folder);

    	//default config

    	$config['image_library'] = 'gd2';
    	$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 75;
		$config['height'] = 50;

    	foreach($map as $file)
    	{
    		//set the filename and the destination name

    		$config['source_image'] = $this->source_folder.$file;
			$config['new_image'] = $this->mobile_destination_folder.$file;

    		//resize the file

    		$this->_ci->image_lib->initialize($config);

			$this->_ci->image_lib->resize();

    		//remove the original file to original folder

    		//empty the uploads folder

    	}

		echo $this->_ci->image_lib->display_errors();
    }

}

