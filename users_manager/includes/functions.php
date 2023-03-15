<?php
if (!defined('_INCODE')) die('Access Deined...');

function layout($layoutName = 'header', $data = []) {
    if (file_exists(_WEB_PATH_TEMPLATE.'/layouts/'.$layoutName.'.php')) {
        require_once _WEB_PATH_TEMPLATE.'/layouts/'.$layoutName.'.php';
    }else {
        echo 'file not exists';
    }
}