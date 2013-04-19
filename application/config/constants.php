<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

//constant to check member in which group
define('ADMIN','admin');
define('PUBLISHER','publisher');
define('CUSTOMER','customer');
define('CUSTOMER_ROLE',2);

##Payment
define('PAYMENT_STEPS_PENDING',0);
define('PAYMENT_STEPS_SENT_AND_WAIT',1);
define('PAYMENT_STEPS_REGISTER',2);
define('PAYMENT_STEPS_SUCCESS',4);

//members group
define('ADMIN_GROUP',1);
define('PUBLISHER_GROUP',3);
define('CUSTOMER_GROUP',4);

define('VIDEO_LIST_PER_PAGE', 80);

##All related to video
define('PAY_PERV_VIEW_DURATION', '31'); ##means 31 days

define('HQ_EMAIL','charles.ling@alphacrossing.com');

##New registration secret hash key
define('SECRET_PASSWORD_SALT','Jloap17$%78930n<ma5n-234KiaoqfaJvhcsBTY');

##Secret video image link hash
define('SECRET_IMG_LINK_SALT','PQqwme*7234sudcnMI*%45y28BAtqj4hjghnMna');

##Secret video link hash
define('SECRET_VID_LINK_SALT',')9123kBsNjkiCnN#6715G31w9KaQlcxre91V3cjas');

##secret video hotlinking
define('SECRET_VID_HOTLINKING', 'Opa8118271badgqGa1tin71Hag29mIKajsaq');

define('SECRET_CREDIT_SALT', '192A83nT^76nsNha&*12noPp01926A35sAMn7908Had');

##General hash
define('SECRET_GENERAL_SALT','MkawYt638*7216NbAhdTkChErd62930cfpolqwMncn');
define('CHANNELS_HASH', 'Is8192nMlpaYq6&12sbqiolamLpsqj212nxan');

define('RECAPTCHA_PRIVATE_KEY','6LcICNASAAAAAKXWmm1lkXIezvNWSYsZAWk7rHJ4');

##Server Library path
define('LOCAL_SERVER_PATH', $_SERVER['DOCUMENT_ROOT'].'/staging/charles/video/');  


/* End of file constants.php */
/* Location: ./application/config/constants.php */