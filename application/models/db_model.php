<?php

##All process regards to booking and calendar will be under here

class DB_Model extends CI_Model {
	
	function get_customer_list($arrData){
		$this->db->select('tb_customer.*');
		$this->db->from('tb_customer');
		
		if (isset($arrData['active'])){
			$this->db->where('tb_customer.active',$arrData['active']);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	function validate_user($arrData){
		$this->db->select('tb_user.user_id,username,role_id');
		$this->db->from('tb_user');
		$this->db->where('tb_user.username',$arrData['username']);
		$query = $this->db->get();
		if ($query->num_rows() > 0){ return $query->row();}
		return false;
	}
	
	function get_all_list($arrData,$per_page=null,$current_page=null){
		$this->db->select('tb_customer.*,tb_license_list.taken,tb_license_list.date_update,tb_license_list.dateupload,tb_license_list.hid as hoya_id');
		$this->db->from('tb_license_list');
		$this->db->join('tb_customer', 'tb_license_list.hid = tb_customer.hid', 'left');
		
		if (isset($arrData['taken'])){
			if ($arrData['taken'] == 'Y'){
				$arrData['taken'] = 'N';
			}else{
				$arrData['taken'] = 'Y';
			}
			$this->db->where('tb_license_list.taken',$arrData['taken']);
		}
		
		if (isset($arrData['hid'])){
			$this->db->where('tb_license_list.hid',$arrData['hid']);
		}
		
		$this->db->order_by("taken", "asc");
		
		if (isset($per_page) && isset($current_page) ){
			$this->db->limit($per_page, $current_page);
		}
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function insert_batch($arrdata){
		$this->db->insert_batch('tb_license_list', $arrdata); 
	}
	
	function check_hid_exist($hid){
		$this->db->select('hid');
		$this->db->from('tb_license_list');
		$this->db->where('hid',$hid);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0){ return true;}
		return false;
	}
	
	function get_hid_customer($hid){
		$this->db->select('hid,customer_id,username,email,full_name');
		$this->db->from('tb_customer');
		
		if (isset($hid))
			$this->db->where('hid',$hid);
			
		$query = $this->db->get();
		
		if ($query->num_rows() > 0){ return $query->row();}
		return false;
	}

	function delete_hid($id){
		$this->db->where('hid', $id);
		$this->db->delete('tb_license_list'); 
	}
	
	function update_profile($data,$id){
		$this->db->where('user_id', $id);
		$this->db->update('tb_user', $data); 
	}
	
	function activate_login($data,$id){
		$this->db->where('hid', $id);
		$this->db->update('tb_customer', $data); 
	}
	
	function update_license_quota($data){
		$this->db->update('license_permission', $data); 
	}
	
	function getTotalLicense(){
		$this->db->select('hid');
		$this->db->from('tb_license_list');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function getTotalLicenseAllowed(){
		$this->db->select('numbers_upload');
		$this->db->from('license_permission');
		$query = $this->db->get();
		return $query->row();
	}
}