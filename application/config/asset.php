<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Asset Directory
|--------------------------------------------------------------------------
|
| Absolute path from the webroot to your CodeIgniter root. Typically this will be your APPPATH,
| WITH a trailing slash:
|
|	/assets/
|
*/

//$config['asset_dir'] = 'assets/';
$config['asset_dir'] = config_item('base_url').'assets/';

/*
|--------------------------------------------------------------------------
| Asset URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	/assets/
|
*/

$config['asset_url'] = config_item('base_url').'assets/';
//var_dump($config['asset_url']);

/*
|--------------------------------------------------------------------------
| Theme Asset Directory
|--------------------------------------------------------------------------
|
*/

$config['theme_asset_dir'] = 'themes/';

/*
|--------------------------------------------------------------------------
| Theme Asset URL
|--------------------------------------------------------------------------
|
*/

$config['theme_asset_url'] = config_item('base_url').'themes/';

/*
|--------------------------------------------------------------------------
| Asset Sub-folders
|--------------------------------------------------------------------------
|
| Names for the img, js and css folders. Can be renamed to anything
|
|	/assets/
|
*/
$config['asset_img_dir'] = 'images';
$config['asset_js_dir'] = 'js';
$config['asset_css_dir'] = 'css';