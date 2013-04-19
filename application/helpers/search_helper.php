<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package		CodeIgniter
* @author		Rick Ellis
* @copyright	Copyright (c) 2006, pMachine, Inc.
* @license		http://www.codeignitor.com/user_guide/license.html
* @link			http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* Code Igniter Search Helpers
*
* @package		CodeIgniter
* @subpackage	Helpers
* @category		Helpers
* @author       Muhammad Fathur Rahman < mhd.fathur@live.com >
*/

// ------------------------------------------------------------------------

function get_search_session()
{
	$ci =& get_instance();
	$search_session = $ci->session->userdata('search');	
	return $search_session;
}

function get_search_post()
{
	$ci =& get_instance();
	$search_post = $ci->input->post();
	return $search_post;	
}

//only use for dropdown

function search_selected($searchfield,$value)
{
	$search_session = get_search_session();

	if(isset($search_session[$searchfield]))
	{
		if($search_session[$searchfield]==$value)
		{
			return 'selected';
		}		
	}

	return '';
}

//only use for dropdown with null value. Eg : All Status

function search_null($searchfield)
{
	$search_post = get_search_post();

	if(($search_post)&&(!$search_post[$searchfield]))
	{
		return 'selected';
	}	
	
	return '';
	
}

//only use for text field

function search_text($searchfield)
{
	$search_session = get_search_session();

	if(isset($search_session[$searchfield]))
	{
		return $search_session[$searchfield];	
	}

	return '';
}

//only use for date text field

function search_date($searchfield)
{
	$search_session = get_search_session();

	if(isset($search_session[$searchfield]))
	{
		$date = date("d-m-Y",strtotime($search_session[$searchfield]));

		return $date;	
	}

	//return date("d-m-Y");
	return '';
}

?>