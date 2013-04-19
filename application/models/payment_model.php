<?php

##All user will in here
class Payment_model extends CI_Model {

	function insert_payment($data){
		$insert = $this->db->insert('tb_payment', $data);
		return $insert;
	}

	function insert_temp_payment_register($data){
		$insert = $this->db->insert('tb_temp_register_payment', $data);
		return $insert;
	}

	function insert_new_credit($data){
		$insert = $this->db->insert('tb_user_wallet', $data);
		return $insert;
	}

	function check_payment_ref($paymet_ref,$steps=0){
		$this->db->where('payment_ref', $paymet_ref);
		if (isset($steps) && $steps > 0){
			$this->db->where('steps', $steps);
		}
		$query = $this->db->get('tb_payment');
		if($query->num_rows !=0)
		{
			return true;
		}
		return false;
	}

	function update_payment_ref($data_update,$payment_ref){
		$this->db->where('payment_ref', $payment_ref);
		$this->db->update('tb_payment', $data_update); 
	}
	
	function update_temp_payment($data_update,$payment_ref){
		$this->db->where('payment_ref', $payment_ref);
		$this->db->update('tb_temp_register_payment', $data_update); 
	}

	function get_payment_history($user_id=null,$payment_ref=null){
		$this->db->select('payment_id,payment_ref,amount,package_name,credit_purchase,days_subs,date_created,payment_status,steps');
		$this->db->from('tb_payment');
		
		if (isset($user_id)){
			$this->db->where('tb_payment.user_id', $user_id);
		}

		if (isset($payment_ref)){
			$this->db->where('tb_payment.payment_ref', $payment_ref);
		}
		$this->db->where('tb_payment.payment_status', 'S');
		$this->db->order_by("date_created", "desc");
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_pending_payment($user_id=null,$payment_ref=null){
		$this->db->select('payment_id,tb_payment.payment_ref,amount,package_name,credit_purchase,tb_payment.date_created,payment_status,tb_temp_register_payment.status,steps,channels,credit');
		$this->db->from('tb_payment');
		$this->db->join('tb_temp_register_payment','tb_temp_register_payment.payment_ref=tb_payment.payment_ref');
		
		if (isset($user_id)){
			$this->db->where('tb_payment.user_id', $user_id);
		}

		if (isset($payment_ref)){
			$this->db->where('tb_payment.payment_ref', $payment_ref);
		}
		$this->db->where('tb_temp_register_payment.status', 'P');
		$this->db->order_by("date_created", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	function get_temp_payment_record($payment_ref){
		$this->db->from('tb_temp_register_payment');
		$this->db->where('tb_temp_register_payment.payment_ref', $payment_ref);
		$this->db->where('tb_temp_register_payment.status', 'P');
		$query = $this->db->get();
		return $query->row();
	}

	##List of credit and channels subs that pay using single payment id. 
	function get_payment_purchase_list($user_id=null,$payment_ref=null,$type='credit'){
		
		$this->db->from('tb_payment');

		if ($type == 'credit'){
			$this->db->select('tb_payment.payment_id,payment_ref,tb_user_wallet.amount_purchase,credit_balance,amount_purchase,date_expired,payment_status,steps');
			$this->db->join('tb_user_wallet','tb_user_wallet.payment_id=tb_payment.payment_id');
		}

		if ($type == 'subs_channel'){
			$this->db->select('tb_payment.payment_id,payment_ref,amount,tb_user_subscription.duration,tb_user_subscription.price as subs_price, payment_status,steps,tb_users.username,tb_users.company');
			$this->db->join('tb_user_subscription','tb_user_subscription.payment_id=tb_payment.payment_id');
			$this->db->join('tb_users','tb_users.id=tb_user_subscription.publisher_id');
		}

		if (isset($user_id)){
			$this->db->where('tb_payment.user_id', $user_id);
		}

		if (isset($payment_ref)){
			$this->db->where('tb_payment.payment_ref', $payment_ref);
		}
		
		$this->db->order_by("date_created", "desc");
		$query = $this->db->get();

		return $query->result();
	}

	function get_subscription_plan_price($plan_id){
		$this->db->from('tb_subscription_plan');
		if (isset($plan_id) && !empty($plan_id)){
			$this->db->where('subscription_plan_id', $plan_id);
		}
		$query = $this->db->get();
		return $query->result();
	}
}
?>