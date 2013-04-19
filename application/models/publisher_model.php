<?php

class Publisher_model extends CI_Model {

	function list_publisher($data=null)
	{
		$this->db->select('tb_users.*,tb_groups.name as group_name');
		$this->db->from('tb_users');
		$this->db->join('tb_users_groups','tb_users.id=tb_users_groups.user_id');			
		$this->db->join('tb_groups','tb_users_groups.group_id=tb_groups.id');
		$this->db->where('tb_groups.id', PUBLISHER_GROUP);			

		//default order by

		if(!isset($data['order_by']))
		{
			$this->db->order_by('tb_users.username','asc');
		}				

		if(isset($data['num']))
		{
			$num = $data['num'];
			$offset = $data['offset'];
			$this->db->limit($num,$offset);
			$query = $this->db->get();
		}		
		else
		{
			$query = $this->db->get();
		}
		
		//var_dump($this->db->last_query());
		//exit;	 

		return $query->result();
	}

	function search_publisher($data=null)
	{
		$this->db->select('tb_users.*,tb_groups.name as group_name');
		$this->db->from('tb_users');
		$this->db->join('tb_users_groups','tb_users.id=tb_users_groups.user_id');			
		$this->db->join('tb_groups','tb_users_groups.group_id=tb_groups.id');
		$this->db->where('tb_groups.id', PUBLISHER_GROUP);

		//START SEARCH FILTER

		$this->_filter($data);

		//END OF SEARCH FILTER

		//default order by. 

		if(!isset($data['order_by']))
		{
			$this->db->order_by('tb_users.username','asc');
		}

		//custom order by

		if((isset($data['order_by']))&&(!empty($data['order_by'])))
		{
			$order_by = $data['order_by'];
			$this->db->order_by($order_by,'desc');
		}		

		if(isset($data['num']))
		{
			$num = $data['num'];
			$offset = $data['offset'];
			$this->db->limit($num,$offset);
			$query = $this->db->get();
		}		
		else
		{
			$query = $this->db->get();
		}

		//var_dump($this->db->last_query());
		//exit;	 		

		return $query->result();
	}

	function _filter($data=null)
	{
		if((isset($data['search_publisher']))&&(!empty($data['search_publisher'])))
		{
			$publisher_id = $data['search_publisher'];			
			$this->db->where('tb_users.id', $publisher_id);
		}

		if((isset($data['search_publisher_username']))&&(!empty($data['search_publisher_username'])))
		{
			$publisher_username = $data['search_publisher_username'];			
			$this->db->where('tb_users.username', $publisher_username);
		}

		if((isset($data['search_publisher_status']))&&(!empty($data['search_publisher_status'])))
		{
			$publisher_status = $data['search_publisher_status'];			
			$this->db->where('tb_users.active', $publisher_status);
		}		
	}
}
?>
