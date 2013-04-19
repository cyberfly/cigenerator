<?php

##All user will in here
class User_model extends CI_Model {    

	function insert_user_credit_history($data){
		$insert = $this->db->insert('tb_user_credit_history', $data);
		return $insert;
	}

	function view_user($userid,$select='all')
	{
		if ($select != 'all'){
			$this->db->select('username,ip_address,email,last_login,active,first_name,last_name,credit_balance,phone');
		}
		$query = $this->db->get_where('tb_users',array('id' => $userid));
		return $query->row();
	}

	function get_all_publisher($user_id=null){
		$this->db->select('tb_users.id as user_id,tb_users.username,tb_users.first_name,tb_users.last_name,tb_users.company');
		$this->db->from('tb_users_groups');
		$this->db->join('tb_users', 'tb_users_groups.user_id = tb_users.id');
		$this->db->where('tb_users_groups.group_id','3');
		if (isset($user_id)){
			$this->db->where('tb_users.id',$user_id);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_user_row($email) 
	{
		$query = $this->db->get_where('tb_users',array('email' => $email));
		return $query->row();
	}

	function update_profile($data,$user_id){
		$this->db->where('id', $user_id);
		$this->db->update('tb_users', $data); 
	}

	function update_wallet_credit_balance($credit_deduct, $user_id){
		$query = "update `tb_user_wallet` set `credit_balance` = `credit_balance` - ".$credit_deduct." WHERE user_id = $user_id and expired='N' order by date_expired asc limit 1";
		$this->db->query($query);
	}

	function get_latest_wallet_balance($user_id,$expired='N'){
		$this->db->select_sum('credit_balance');
		$this->db->from('tb_user_wallet');
		$this->db->where('user_id', $user_id);
		$this->db->where('expired', $expired);
		$query = $this->db->get();
		return $query->row();
	}
}
?>