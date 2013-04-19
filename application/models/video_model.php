<?php


##All video data will be in here.
##Author : Charles Ling
##Date : 13 April 2012
##Desc : Video related Model. Please sanitazi all user input before insert.


class Video_model extends CI_Model {

	################## Insert Function ############################

	##Create new video
    function create_video($data)
	{
		$insert = $this->db->insert('tb_video', $data);
		$last_id = $this->db->insert_id();
		return $last_id;
	}

	##create new video file. One video can have multiple format
	function create_video_file($data){
		$insert = $this->db->insert('tb_video_file', $data);
		$last_id = $this->db->insert_id();
		return $last_id;
	}

	function create_video_trailer($data){
		$insert = $this->db->insert('tb_trailer', $data);
		return $this->db->insert_id();
	}

	function view_video($video_id)
	{
		$this->db->where('tb_video.video_id', $video_id);
		$query = $this->db->get('tb_video');
		return $query->row();
	}

	function edit_video($data,$video_id)
	{
		$this->db->where('tb_video.video_id', $video_id);
		return $this->db->update('tb_video', $data);
	}

	function insert_video_like($data){
		$insert = $this->db->insert('tb_video_like', $data);
		return $insert;
	}

	function insert_video_view($data){
		$insert = $this->db->insert('tb_video_view', $data);
		return $insert;
		return false;
	}

	function insert_video_user_fav($data){
		$insert = $this->db->insert('tb_user_fav_video', $data);
		return $insert;
	}

	function insert_video_user_rating($data)
	{
		//check for duplicate user view
		if(!$this->check_duplicate_rating($data))
		{
			$insert = $this->db->insert('tb_video_rating',$data);
			return $insert;
		}
		return false;
	}


	function insert_video_user_get_videos($data)
	{
		//check for duplicate user view

		if(!$this->check_duplicate_rating($data))
		{
			$insert = $this->db->insert('tb_video_rating',$data);
			return $insert;
		}

		return false;

	}

	function insert_video_purchase($data){
		$insert = $this->db->insert('tb_user_video_purchase',$data);
		return $insert;
	}

	function subscribe_channels($data){
		$insert = $this->db->insert('tb_user_subscription',$data);
		return $insert;
	}

	################## Update Function ############################

	function update_video($update_data){

	}

	function update_video_file($update_data){

	}

	function update_video_trailer($update_data){

	}

	function update_video_rate($update_data){

	}

	function update_video_view_count($update_data){

	}

	################## GET Function ############################

	function get_single_video($video_id)
	{
		$this->db->select('tb_video.*,tb_video_file.type,tb_video_file.link,tb_video_file.video_hash,tb_video_file.date_upload');
		$this->db->join('tb_video_file', 'tb_video_file.video_id = tb_video.video_id');
		$this->db->where('tb_video.video_id', $video_id);
		$query = $this->db->get_where('tb_video',$video_id);
		$this->db->where('tb_video.active', 'Y');
	}

	##Get video by video id or all, with limit. Vy default limit set to 10.
	function get_videos($video_id=null,$video_file=false,$trailer_file=false,$start=0,$limit=9,$sort_by='date_desc')
	{
		$this->db->select('tb_video.*,tb_users.username as publisher_name,tb_users.company');
		$this->db->from('tb_video');
		$this->db->join('tb_users','tb_users.id=tb_video.publisher_id');

		if (isset($video_file) && $video_file){
			$this->db->select('tb_video_file.type,tb_video_file.link,tb_video_file.video_hash,tb_video_file.date_uploaded');
			$this->db->join('tb_video_file', 'tb_video_file.video_id = tb_video.video_id');
		}

		if (isset($trailer_file) && $trailer_file){
			$this->db->select('tb_trailer.trailer_id,tb_trailer.trailer_link,trailer_hash');
			$this->db->join('tb_trailer', 'tb_trailer.video_id = tb_video.video_id');
		}

		$this->db->where('tb_video.active', 'Y');
		if (isset($video_id) && !empty($video_id)){
			$this->db->where('tb_video.video_id',$video_id);
		}
		##Just added new video
		if ($sort_by == 'date_desc')
		{
			$this->db->order_by("video_id", "desc");
		}else if ($sort_by == 'total_score')
		{
			##Top rating video
			$this->db->order_by("total_score", "desc");
		}else if ($sort_by == 'total_view')
		{
			##Top view video
			$this->db->order_by("total_view", "desc");
		}
		if ($limit != 0){
			$this->db->limit($limit, $start);
		}

		$query = $this->db->get();

		if (isset($video_id) && !empty($video_id)){
			return $query->row();
		}else{
			return $query->result();
		}
	}

	##Get list of videos category depends on the video or by category
	function get_video_category($video_id=null,$category_id=null,$selectType='all',$limit=0,$order_by=null)
	{
		if ($selectType != 'all'){
			$this->db->select('category_name,tb_category.category_id');
		}else{
			$this->db->select('tb_video.*,category_name,tb_category.category_id');
		}
		$this->db->from('tb_video');
		$this->db->join('tb_video_category', 'tb_video.video_id = tb_video_category.video_id');
		$this->db->join('tb_category', 'tb_category.category_id = tb_video_category.category_id');

		if (isset($video_id)){
			$this->db->where('tb_video.video_id', $video_id);
		}

		if (isset($category_id)){
			$this->db->where('tb_video_category.category_id', $category_id);
		}
		$this->db->where('tb_video.active', 'Y');

		if (isset($order_by)){
			$this->db->order_by($order_by, "desc");	
		}
		
		if ($limit != 0){
			$this->db->limit($limit);
		}

		$query = $this->db->get();
		return $query->result();
	}

	##Get video tag list
	/*function get_video_tags($video_id=null,$tag_id=null)
	{
		$this->db->select('tb_video.*,title,tag_id');
		$this->db->from('tb_video');
		$this->db->join('tb_video_tag', 'tb_video.video_id = tb_video_tag.video_id');
		$this->db->join('tb_tag', 'tb_tag.tag_id = tb_video_tag.tag_id');

		if (isset($video_id)){
			$this->db->where('tb_video.video_id', $video_id);
		}

		if (isset($tag_id)){
			$this->db->where('tb_video_tag.tag_id', $tag_id);
		}
		$this->db->where('tb_video.active', 'Y');
		$query = $this->db->get();
		return $query->result();
	}*/

	function mb_get_video_tag($tag_id)
	{
		$this->db->select('tb_tag.title,tb_tag.tag_id,tb_video.*');
		$this->db->from('tb_video_tag');
		$this->db->join('tb_tag', 'tb_tag.tag_id = tb_video_tag.tag_id');
		$this->db->join('tb_video', 'tb_video.video_id = tb_video_tag.video_id');
		$this->db->where('tb_video_tag.tag_id', $tag_id);
		//var_dump($this->db->last_query());
		$query = $this->db->get();
		return $query->result();
	}

	function get_video_purchase($video_id=null){

		$this->db->select('tb_user_video_purchase.*');
		$this->db->from('tb_user_video_purchase');
		if (isset($video_id)){
			$this->db->where('tb_user_video_purchase.video_id', $video_id);
		}
		if (isset($user_id)){
			$this->db->where('tb_user_video_purchase.video_id', $video_id);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function get_video_subscribe($video_id){
		$this->db->select('tb_user_video_purchase.*');
		$this->db->from('tb_user_video_purchase');
		if (isset($video_id)){
			$this->db->where('tb_user_video_purchase.video_id', $video_id);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function get_my_channels_subs($user_id){
		$this->db->select('tb_user_subscription.*,tb_users.company,tb_users.username');
		$this->db->from('tb_user_subscription');
		$this->db->join('tb_users', 'tb_users.id = tb_user_subscription.publisher_id');
		if (isset($video_id)){
			$this->db->where('tb_user_subscription.user_id', $user_id);
		}
		$query = $this->db->get();
		return $query->result();
	}

	//created by fathur
	##charles i comment out your function first - use this function (charles)
	function get_video_tags($video_id)
	{
		$this->db->select('tb_tag.title,tb_tag.tag_id');
		$this->db->from('tb_video_tag');
		$this->db->join('tb_tag', 'tb_tag.tag_id = tb_video_tag.tag_id');
		$this->db->where('tb_video_tag.video_id', $video_id);
		$query = $this->db->get();
		return $query->result();
	}

	##check video already insert
	function check_insert_video($video_ref_id)
	{
		$this->db->where('video_ref_id', $video_ref_id);
		$query = $this->db->get('tb_video');
		if($query->num_rows !=0)
		{
			return true;
		}
		return false;
	}

	##check video already purchase
	function check_purchase_video($video_id,$user_id)
	{
		$this->db->where('video_id', $video_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('tb_user_video_purchase');
		if($query->num_rows !=0)
		{
			return true;
		}
		return false;
	}

	//check video already favourite
	function check_favourite_video($video_id,$user_id)
	{
		$this->db->where('video_id', $video_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('tb_user_fav_video');
		if($query->num_rows !=0)
		{
			return true;
		}
		return false;
	}

	//check already subscribe to publisher
	function check_subscribe_publisher($publisher_id,$user_id)
	{
		$this->db->where('publisher_id', $publisher_id);
		$this->db->where('user_id', $user_id);
		$this->db->where('active', 'Y');
		$query = $this->db->get('tb_user_subscription');

		if($query->num_rows !=0)
		{
			return true;
		}

		return false;
	}

	function check_duplicate_view($data)
	{
		$this->db->where('video_id', $data['video_id']);
		$this->db->where('user_id', $data['user_id']);
		$query = $this->db->get('tb_video_view');
		if($query->num_rows !=0)
		{
			return true;
		}

		return false;
	}

	//check user already rate or not

	function check_already_rate($video_id,$user_id)
	{
		$this->db->where('video_id', $video_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('tb_video_rating');
		if($query->num_rows !=0)
		{
			return true;
		}

		return false;
	}

	//check for duplicate rating

	function check_duplicate_rating($data)
	{
		$this->db->where('video_id', $data['video_id']);
		$this->db->where('user_id', $data['user_id']);
		$query = $this->db->get('tb_video_rating');
		if($query->num_rows !=0)
		{
			return true;
		}
		return false;
	}

	//check for if the user already owned the video
	function check_duplicate_video_purchase($data)
	{
		$this->db->where('video_id', $data['video_id']);
		$this->db->where('user_id', $data['user_id']);
		$query = $this->db->get('tb_user_video_purchase');
		if($query->num_rows !=0)
		{
			return true;
		}
		return false;
	}

	function get_video_total_purchased($video_id)
	{
		$this->db->from('tb_user_video_purchase');
		$this->db->where('video_id', $video_id);
		return $this->db->count_all_results();
	}

	//get the video total favourite

	function get_video_total_favourite($video_id)
	{
		$this->db->from('tb_user_fav_video');
		$this->db->where('video_id', $video_id);
		return $this->db->count_all_results();
	}

	//get the video total subscribe

	function get_video_total_subscribe($video_id)
	{
		$this->db->from('tb_user_subscription_video');
		$this->db->where('video_id', $video_id);
		return $this->db->count_all_results();
	}

	//get the publisher total subscribe

	function get_publisher_total_subscribe($publisher_id)
	{
		$this->db->from('tb_user_subscription');
		$this->db->where('publisher_id', $publisher_id);
		return $this->db->count_all_results();
	}
	
	// Get user subscribe channel
	function get_subscribe_channels($publisher_id,$user_id)
	{
		$this->db->select('tb_user_subscription.*');
		$this->db->where('publisher_id', $publisher_id);
		$this->db->where('user_id', $user_id);
		$this->db->where('active', 'Y');
		$query = $this->db->get('tb_user_subscription');
		return $query->row();
	}

	//get the video file

	function get_video_file($video_id)
	{
		$this->db->select('tb_video_file.*');
		$this->db->from('tb_video_file');
		$this->db->where('video_id', $video_id);
		$query = $this->db->get();
		return $query->result();
	}

	//get the last id so we know it there is no video list to load via ajax

	function get_last_video_id($data=null,$order='desc')
	{
		$this->db->select_min('video_id');

		if($order=='asc')
		{
			$this->db->select_max('video_id');
		}

		$this->db->from('tb_video');

		//default order by. use by mobile home. newest video will be on top.

		if(!isset($data['order_by']))
		{
			$this->db->order_by('tb_video.video_id','desc');
		}

		//custom order by. use by top view, top rating list

		if((isset($data['order_by']))&&(!empty($data['order_by'])))
		{
			$order_by = $data['order_by'];
			$this->db->order_by($order_by,'desc');
		}

		$query = $this->db->get();

		return $query->row()->video_id;

	}

	//get the last video id for mobile top rate list and top view list

	function get_last_top_video_id($data=null)
	{
		$this->db->select('tb_video.*');

		$this->db->from('tb_video');

		if((isset($data['order_by']))&&(!empty($data['order_by'])))
		{
			$order_by = $data['order_by'];
			$this->db->order_by($order_by,'desc');
		}

		$query = $this->db->get();

		$last_video_id = 0;

		if($query->result())
		{
			foreach($query->result() as $row)
			{
				$last_video_id = $row->video_id;
			}
		}

		return $last_video_id;

	}

	// created by oscar get my video function
	function get_user_video_purchase($user_id){
		$this->db->select('tb_video.*,tb_user_video_purchase.*');
		$this->db->from('tb_video');
		$this->db->join('tb_user_video_purchase', 'tb_video.video_id = tb_user_video_purchase.video_id');
		$this->db->where('user_id', $user_id);
		$this->db->order_by('tb_user_video_purchase.date_purchase','desc');
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
		return $query->result();
	}

	function get_user_favourite_video($user_id){
		$this->db->select('tb_video.*,tb_user_fav_video.*');
		$this->db->from('tb_video');
		$this->db->join('tb_user_fav_video', 'tb_video.video_id = tb_user_fav_video.video_id');
		$this->db->where('user_id', $user_id);
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
		return $query->result();
	}

	function get_total_publisher_vid($publisher_id){
		$this->db->where('publisher_id', $publisher_id);
		$query = $this->db->get('tb_video');
		return $query->num_rows;
	}
	
	function mobile_channel_video($channel_id)
	{
		$this->db->select('tb_video.*,tb_users.*');
		$this->db->from('tb_video');
		$this->db->join('tb_users','tb_users.id = tb_video.publisher_id');		
	    $this->db->where('publisher_id', $channel_id);
			
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
		return $query->result();
	
	}

	##based on top view and total votes
	function get_suggested_video($order_by){
		return $this->search_video(array('order_by'=>$order_by,'num'=>10,'offset'=>0));
	}

	##get mv related based on same category
	function get_movie_related($category_id){
		$mv_category = $this->get_video_category(null, $category_id, 'all', 6,'tb_video.video_id');
		return $mv_category;
	}

	function list_video($data=null)
	{
		$this->db->select('tb_video.*');
		$this->db->from('tb_video');

		//AJAX OFFSET

		if((isset($data['home_ajax_offset']))&&(!empty($data['home_ajax_offset'])))
		{
			$home_ajax_offset = $data['home_ajax_offset'];
			$this->db->where('tb_video.video_id >=', $home_ajax_offset);
		}

		if((isset($data['ajax_offset']))&&(!empty($data['ajax_offset'])))
		{
			$ajax_offset = $data['ajax_offset'];
			$this->db->where('tb_video.video_id <', $ajax_offset);
		}

		//END OF AJAX OFFSET

		//default order by. use by mobile home. newest video will be on top.

		if(!isset($data['order_by']))
		{
			$this->db->order_by('tb_video.video_id','desc');
		}

		//custom order by. use by top view, top rating list

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
		else if(isset($data['ajax_num']))
		{
			$ajax_num = $data['ajax_num'];
			$this->db->limit($ajax_num);
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

	function search_video($data=null)
	{
		$this->db->select('tb_video.*,tb_users.username as publisher_name');
		$this->db->from('tb_video');
		$this->db->join('tb_users','tb_users.id=tb_video.publisher_id');

		//START SEARCH FILTER

		$this->_filter($data);

		//END OF SEARCH FILTER

		//default order by.

		if(!isset($data['order_by']))
		{
			$this->db->order_by('tb_video.video_id','desc');
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
		if((isset($data['search_video_name']))&&(!empty($data['search_video_name'])))
		{
			$video_name = $data['search_video_name'];
			$this->db->like('tb_video.video_name', $video_name);
		}

		if((isset($data['search_video_status']))&&(!empty($data['search_video_status'])))
		{
			$video_status = $data['search_video_status'];
			$this->db->where('tb_video.active', $video_status);
		}

		if((isset($data['search_publisher']))&&(!empty($data['search_publisher'])))
		{
			$publisher_id = $data['search_publisher'];
			$this->db->where('tb_video.publisher_id', $publisher_id);
		}
	}

	function search_video_total_count($text_search){
		$query = "SELECT video_id FROM `tb_video` WHERE MATCH(video_name,actor) AGAINST ('$text_search')";
		$query = $this->db->query($query);
		return $query->num_rows();
	}

	function search_video_text($text_search,$start,$limit_perpage=9){
		$query = "SELECT * FROM `tb_video` WHERE MATCH(video_name,actor) AGAINST ('$text_search') order by total_score desc limit  $start,$limit_perpage";
		$query = $this->db->query($query);
		return $query->result();
	}

	function mobile_search_video($data=null)
	{
		$this->db->select('tb_video.*');
		$this->db->from('tb_video');

		$text_search = $data['search_term'];
		
		$where = "MATCH(video_name,actor) AGAINST ('$text_search')";

		$this->db->where($where);
		
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

		return $query->result();
	}

	function search_category_total(){

	}

	function search_category(){

	}

	function search_tags_total(){

	}

	function search_tags(){

	}

	function get_video_user_fav($data){
		$insert = $this->db->insert('tb_user_fav_video', $data);
		return $insert;
	}

}
?>
