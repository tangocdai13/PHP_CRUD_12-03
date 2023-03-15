<?php
/*
 * File chua cac hang so cau hinh
 * */
const _MODULE_DEFAULT = 'home'; //Module mặc định
const _ACTION_DEFAULT = 'lists'; //Action mặc định
const _INCODE = true; //Ngăn chặn hành vi truy cập trực tiếp vào file

//thiết lập host
define('_WEB_HOST_ROOT', 'http://'.$_SERVER['HTTP_HOST'].'/PHP_Do_An/users_manager'); //Địa chỉ trang chủ
define('_WEB_HOST_TEMPLATE', _WEB_HOST_ROOT.'/templates');

//Thiết lập path
define('_WEB_PATH_ROOT', __DIR__);
define('_WEB_PATH_TEMPLATE', _WEB_PATH_ROOT.'/templates');

//Thiết lập kết nối database
const _HOST = 'localhost';
const _USER = 'root';
const _PASS = 'root';
const _DB = 'phponline';
const _DRIVER = 'mysql';