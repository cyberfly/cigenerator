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

function get_ci_instance()
{
	$ci =& get_instance();
	return $ci;	
}

function get_header_active_link($page,$uri)
{
	//for home page	

	$header_link['home'] = array(
							'portal_video/index',
							'portal_video/search_video',
							'portal/index',
							'portal_video/edit_video'
							);

	//for profile page

	$header_link['profile'] = array(
							  'user/portal_update_profile'
							  );

	//for publisher page

	$header_link['publisher'] = array(
								'publisher/index',
								'publisher/add_publisher',
								'publisher/edit_publisher',
								'publisher/search_publisher' 
								);

	//for member page

	$header_link['member'] = array(
								'member/index',
								'member/add_member',
								'member/edit_member',
								'member/list_member_purchase',
								'member/list_member_subscription',
								'member/list_member_favourite',
								'member/search_member'
								);

	//if no array exist

	if(!isset($header_link[$page]))
	{
		return '';
	}	

	if(in_array($uri, $header_link[$page]))
	{
		return 'active';
	}
	else{
		return '';
	}

}

function get_sidebar_active_link($page,$uri)
{
	//for home page	

	$sidebar_link['home'] = array(
							'portal_video/index',
							'portal_video/search_video',
							'portal/index'
							);
	
	if(in_array($uri, $header_link[$page]))
	{
		return 'active';
	}
	else{
		return '';
	}

} 

?>