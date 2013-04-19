<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permission {
	
	private $_ci;

	function __construct()
	{
		$this->_ci = &get_instance();
		$this->_ci->load->library('ion_auth');			
		//$this->_ci->load->library('session');			
	}

	public function is_logged_in_portal()
	{
		if (!$this->_ci->ion_auth->logged_in())
		{
			redirect('login/portal_index');
		}

		//if not admin and publisher

		if ((!$this->_ci->ion_auth->is_admin())&&(!$this->_ci->ion_auth->in_group(PUBLISHER)))
		{
			redirect('login/portal_index');
		}
	}

	public function is_logged_in_mobile($current_page=null)
	{		
		if((isset($current_page))&&(!empty($current_page)))
		{			
			$this->_ci->session->set_userdata('redirect_page',$current_page);
		}	

		if (!$this->_ci->ion_auth->logged_in())
		{
			redirect('home/sign_in');
		}		
	}

	public function admin_only()
	{
		if (!$this->_ci->ion_auth->is_admin())
		{
			$this->_ci->session->set_flashdata('error', 'Error. You dont have permission to access that page.');
			redirect('portal/index');
		}
	}

	public function publisher_only()
	{
		if (!$this->_ci->ion_auth->in_group(PUBLISHER))
		{
			$this->_ci->session->set_flashdata('error', 'Error. You dont have permission to access that page.');
			redirect('portal/index');
		}
	}	
		
}

// END Reply Class

/* End of file Reply.php */
/* Location: ./application/libraries/Reply.php */