<?php 
const _MODULE_DEFAULT = 'home'; //module mặc định
const _ACTION_DEFAULT = 'lists'; //action mặc định


const _INCODE = true; // ngăn chặn hành vi truy cập trực tiếp vào file
// Thiết lập host
define('_WEB_HOST_ROOT','http://' .$_SERVER['HTTP_HOST'].'/UserManagement');
define('_WEB_HOST_TEMPLATE',_WEB_HOST_ROOT.'/templates');
// Thiết lập path
define('_WEB_PATH_ROOT',__DIR__);
define('_WEB_PATH_TEMPLATE',_WEB_PATH_ROOT.'/templates');
//Thêm kết nối dtb
const _HOST = 'localhost';
const _USER = 'root';
const _PASS = '';
const _DB = 'usermanagement';
const _DRIVER = 'mysql';
?>