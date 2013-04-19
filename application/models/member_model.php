<?php

class Member_model extends CI_Model {

	function list_member($data=null)
	{
		$this->db->select('tb_users.*,tb_groups.name as group_name');
		$this->db->from('tb_users');
		$this->db->join('tb_users_groups','tb_users.id=tb_users_groups.user_id');			
		$this->db->join('tb_groups','tb_users_groups.group_id=tb_groups.id');
		$this->db->where('tb_groups.id', CUSTOMER_GROUP);			

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

	function search_member($data=null)
	{
		$this->db->select('tb_users.*,tb_groups.name as group_name');
		$this->db->from('tb_users');
		$this->db->join('tb_users_groups','tb_users.id=tb_users_groups.user_id');			
		$this->db->join('tb_groups','tb_users_groups.group_id=tb_groups.id');
		$this->db->where('tb_groups.id', CUSTOMER_GROUP);	

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
		if((isset($data['search_member']))&&(!empty($data['search_member'])))
		{
			$member_id = $data['search_member'];			
			$this->db->where('tb_users.id', $member_id);
		}

		if((isset($data['search_member_username']))&&(!empty($data['search_member_username'])))
		{
			$member_username = $data['search_member_username'];			
			$this->db->where('tb_users.username', $member_username);
		}

		if((isset($data['search_member_status']))&&(!empty($data['search_member_status'])))
		{
			$member_status = $data['search_member_status'];			
			$this->db->where('tb_users.active', $member_status);
		}

	}

	//search the member purchased

	function search_member_purchase($data=array())
	{		
		$this->db->select('tb_user_video_purchase.*,tb_video.video_name,member.username as member_username, publisher.username as publisher_username ');
		$this->db->from('tb_user_video_purchase');
		$this->db->join('tb_video','tb_user_video_purchase.video_id=tb_video.video_id');
		$this->db->join('tb_users as member','tb_user_video_purchase.user_id=member.id');
		$this->db->join('tb_users as publisher','tb_user_video_purchase.publisher_id=publisher.id');

		if((isset($data['search_member']))&&(!empty($data['search_member'])))
		{
			$member_id = $data['search_member'];			
			$this->db->where('tb_user_video_purchase.user_id', $member_id);
		}		

		$query = $this->db->get();

		//var_dump($this->db->last_query());

		return $query->result();
	}

	//search the member favourite

	function search_member_favourite($data=array())
	{		
		$this->db->select('tb_user_fav_video.*,tb_video.video_name,member.username as member_username, publisher.username as publisher_username ');
		$this->db->from('tb_user_fav_video');
		$this->db->join('tb_video','tb_user_fav_video.video_id=tb_video.video_id');
		$this->db->join('tb_users as member','tb_user_fav_video.user_id=member.id');
		$this->db->join('tb_users as publisher','tb_video.publisher_id=publisher.id');

		if((isset($data['search_member']))&&(!empty($data['search_member'])))
		{
			$member_id = $data['search_member'];			
			$this->db->where('tb_user_fav_video.user_id', $member_id);
		}		

		$query = $this->db->get();

		//var_dump($this->db->last_query());

		return $query->result();
	}	

	//search the member subscription

	function search_member_subscription($data=array())
	{		
		$this->db->select('tb_user_subscription.*,tb_subscription_plan.*,member.username as member_username, publisher.username as publisher_username ');
		$this->db->from('tb_user_subscription');			
		$this->db->join('tb_subscription_plan','tb_user_subscription.subscription_plan_id=tb_subscription_plan.subscription_plan_id');
		$this->db->join('tb_users as member','tb_user_subscription.user_id=member.id');
		$this->db->join('tb_users as publisher','tb_user_subscription.publisher_id=publisher.id');		

		if((isset($data['search_member']))&&(!empty($data['search_member'])))
		{
			$member_id = $data['search_member'];			
			$this->db->where('tb_user_subscription.user_id', $member_id);
		}		

		if((isset($data['search_active']))&&(!empty($data['search_active'])))
		{
			$today = date('Y-m-d');			
			$this->db->where('date(tb_user_subscription.date_expired)<', $today);
		}

		if((isset($data['search_expired']))&&(!empty($data['search_expired'])))
		{
			$today = date('Y-m-d');			
			$this->db->where('date(tb_user_subscription.date_expired)>=', $today);
		}		

		$query = $this->db->get();

		//var_dump($this->db->last_query());

		return $query->result();
	}

	

	
	
}
?>
