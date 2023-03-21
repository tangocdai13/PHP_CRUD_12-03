<?php
/*
 * File này chức năng kích hoạt tài khoản
 * */
if (!defined('_INCODE')) die('Access Deined...');
layout('header-login');
echo '<div class="container text-center"><br>';
if (!empty(getBody()['token'])) {
    $token = getBody()['token'];
}
if (!empty($token)) {
    //Truy vấn kiểm tra Token với database
    $tokenQuery = firstRaw("SELECT id, fullname, email FROM users WHERE activeToken='$token'");
    if (!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        $dataUpdate = [
            'status' => 1,
            'activeToken' => null
        ];
        $updateStatus = update('users', $dataUpdate, "id=$userId");
        if ($updateStatus) {
            setFlashData('msg', 'Kích hoạt tài khoản thành công! Bạn có thể đăng nhập ngay bây giờ');
            setFlashData('msg_type', 'success');
            //Tạo link Login
            $loginLink = _WEB_HOST_ROOT.'?module=auth&action=login';
            //Gửi mail khi kích hoạt thành công
            $subject = 'Kích hoạt tài khoản thành công';
            $content .= 'Chúc mừng '.$tokenQuery['fullname'].' đã kích hoạt thành công'.'<br>';
            $content .= 'Bạn có thể đăng nhập tại link sau: '.$loginLink.'<br>';
            $content .= 'Trân trọng';
            //Send Email
            sendMail($tokenQuery['email'], $subject, $content);
        }else {
            setFlashData('msg', 'Kích hoạt tài khoản không thành công! Vui lòng liên hệ lại với quản trị viên');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=auth&action=login');
    }else {
        msgFlash('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
    }
}else {
    msgFlash('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
}

echo '</div>';
layout('footer-login');