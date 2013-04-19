<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Sidebardata Library
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category		Libraries
 * @author       Muhammad Fathur Rahman Che Mohd Nasir < mhd.fathur@live.com >
 */

class Searchdata {

	private $_ci;

	function __construct()
	{
		$this->_ci = &get_instance();
		$this->_ci->load->library('ion_auth');
		$this->search_array = array();
		$this->search_session = array();			
	}

	//this method used to set the session if there search form submitted

	public function _set()
	{
		//if from pagination, do nothing

		if(!$this->_ci->input->post())
		{			
			return false;			
		}

		//if search, destroy previous search session

		$this->_ci->session->unset_userdata('search');	

		//set the post search

		$this->set_post_search();

		//set the search based on role

		$this->set_role_post_search();

		//store the search into search array segment
		//eg $session_var = array("search"=> array('search_branch' => 1));

		$search_session = array('search'=>$this->search_array);

		//store search array segment into array

		if(!empty($search_session))
		{
			$this->_ci->session->set_userdata($search_session);
		}	
	}

	public function set_post_search()
	{
		foreach($this->_ci->input->post() as $key => $value)
		{
			if($this->_ci->input->post($key))
			{
				$search_value = $this->_ci->input->post($key);

				$search_variable = 'search_'.$key;

				if(($key=='startdate')||($key=='enddate'))
				{
					$search_value = date("Y-m-d",strtotime($this->_ci->input->post($key)));
				}				

				$$search_variable = $search_value; //eg $search_customer				

				$this->search_array = $this->search_array + array("search_$key"=>$search_value);				

			}
		}
	}	

	public function set_role_post_search()
	{
		if($this->_ci->ion_auth->in_group(PUBLISHER))
		{			
			$search_publisher = $this->_ci->session->userdata('user_id');
			$search_publisher = 19;			
			$this->search_array = $this->search_array + array("search_publisher"=>$search_publisher);
		}	
	}

	//this method used for index list only

	public function set_role_search()
	{		
		//if from pagination, do nothing

		if($this->_ci->uri->segment(3))
		{					
			return false;			
		}

		//clear search session

		$this->_ci->session->unset_userdata('search');	

		$this->set_role_post_search();

		//store the search into search array segment
		//eg $session_var = array("search"=> array('search_branch' => 1));

		$search_session = array('search'=>$this->search_array);
		
		//store search array segment into array

		if(!empty($search_session))
		{
			$this->_ci->session->set_userdata($search_session);
		}
	} 	

}

// END Sidebardata Class

/* End of file Sidebardata.php */
/* Location: ./application/libraries/Sidebardata.php */