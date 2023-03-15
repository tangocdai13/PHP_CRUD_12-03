<?php
/*
 * Chua cac ham lien quan den thao tac session
 * */
if (!defined('_INCODE')) die('Access Deined...');

//Hàm gán Session
function setSession($key, $value) {
    if (!empty(session_id())) {
        $_SESSION[$key] = $value;
        return true;
    }

    return false;
}

//Hàm đọc Session
function getSession($key='') {
    if (empty($key)) {
        return $_SESSION;
    }else {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    return false;
}

//Hàm xoá Session
function removeSession($key='') {
    if (empty($key)) {
        session_destroy();
        return true;
    }else {
        if (isset($_SESSION[$key])){
            unset($_SESSION[$key]);
            return true;
        }
    }

    return false;
}

//Hàm gán flash data
function setFlashData($key, $value) {
    $key = 'flash_'.$key;
    return setSession($key, $value);
}

//Hàm đọc flash data
function getFlashData($key) {
    $key = 'flash_'.$key;
    $data = getSession($key);
    removeSession($key); //xoa key, giu lai data => return ve data
    return $data;
}