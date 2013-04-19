<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Sidebardata Library
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category		Libraries
 * @author       Muhammad Fathur Rahman Che Mohd Nasir < mhd.fathur@live.com >
 */

class Sidebardata {

	private $_ci;

	function __construct()
	{
		$this->_ci = &get_instance();
		$this->_ci->load->library('ion_auth');
		$this->publisher = null;
		$this->data = array();
		$this->search_session = $this->_ci->session->userdata('search');
		$this->_set();
	}

	private function _set()
	{		
		if($this->_ci->ion_auth->in_group(PUBLISHER))
		{			
			$this->publisher = $this->_ci->session->userdata('user_id');	
		}	

		//if admin group

		if($this->_ci->ion_auth->in_group(ADMIN))
		{			
			$this->publisher = (isset($this->search_session['search_publisher'])) ? $this->search_session['search_publisher'] : $this->publisher;
		}		
	}

	public function _get($method=null)
	{
		if(!empty($method))
		{
			foreach($method as $name)
			{
				$method_name = 'list_'.$name;

				$this->$method_name();
			}	
		}	

		return $this->data;
	}

	public function list_publisher()
	{
		$this->_ci->load->model('publisher_model');

		if($query = $this->_ci->publisher_model->list_publisher())
		{
			$this->data['publisher_list'] = $query;
		}

		return $this->data;
	}
	
	
}

// END Sidebardata Class

/* End of file Sidebardata.php */
/* Location: ./application/libraries/Sidebardata.php */