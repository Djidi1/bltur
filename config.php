<?php

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    define ('DB_HOST','localhost');
	define ('DB_DATABASE','bltur');
	define ('DB_USER','root');
	define ('DB_PASS','');
} else {
    define ('DB_HOST','mysql.u0144155.z8.ru');
	define ('DB_DATABASE','db_u0144155_1');
	define ('DB_USER','dbu_u0144155_1');
	define ('DB_PASS','7lrnXx8Wq9');
}

define ('DB_USE','mySQL');

define ('DB_TAB_PREF','');
define ('TAB_PREF','');

define ('br','<br />');
define ('rn',"\r\n");
define ('bn',"<br />\r\n");

