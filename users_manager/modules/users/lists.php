<?php
/*
 * Danh sach Users
 * */
if (!defined('_INCODE')) die('Access Deined...');
if (!isLogin()) {
    redirect('?module=auth&action=login');
}
echo 'Day la list cua module User'.'<br>';
