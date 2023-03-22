<?php
/*
 * File này chưa các chức năng đăng nhập
 * */
if (!defined('_INCODE')) die('Access Deined...');
$data = ['pageTitle' => 'Đăng nhập hệ thống'];
layout('header-login', $data);

//Kiểm tra trạng thái đăng nhập
if (isLogin()) {
    redirect('?module=users');
}
//Xử lí đăng nhập
if (isPost()) {
    $body = getBody();
    if (!empty(trim($body['email'])) && !empty(trim($body['password']))) {
        //Kiểm tra đăng nhập
        $email = $body['email'];
        $password = $body['password'];

        //Truy vấn lấy thông tin user theo mail
        $userQuery = firstRaw("SELECT id, password FROM users WHERE email='$email'");
        if (!empty($userQuery)) {
            $passwordHash = $userQuery['password'];
            $userId = $userQuery['id'];
            if (password_verify($password, $passwordHash)) {
                //Tạo Token Login
                $tokenLogin = sha1(uniqid().time());

                //Insert dữ liệu vào bảng login_token
                $dataToken = [
                    'userId' => $userId,
                    'token' => $tokenLogin,
                    'createAt' => date('Y-m-d H:i:s')
                ];

                $insertTokenStatus = insert('login_token', $dataToken);
                if ($insertTokenStatus) {
                    //Insert thanh cong

                    //Lưu loginToken vào session
                    setSession('loginToken', $tokenLogin);

                    //Chuyển hướng qua trang quản lý users
                    redirect('?module=users');
                }else {
                    setFlashData('msg', 'Lỗi hệ thống, bạn không thể đăng nhập ngay lúc này!');
                    setFlashData('msg_type','danger');
//                    redirect('?module=auth&action=login');
                }
            }else {
                setFlashData('msg', 'Mật khẩu không chính xác');
                setFlashData('msg_type','danger');
//                redirect('?module=auth&action=login');
            }
        }else {
            setFlashData('msg', 'Email không tồn tại trên hệ thống');
            setFlashData('msg_type','danger');
//            redirect('?module=auth&action=login');
        }
    }else {
        setFlashData('msg','Vui lòng nhập email và mật khẩu');
        setFlashData('msg_type','danger');
//        redirect('?module=auth&action=login');
    }

    redirect('?module=auth&action=login');
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>

<div class="row">
    <div class="col-6" style="margin: 20px auto;">
        <h3 class="text-center text-uppercase">Đăng nhập hệ thống</h3>
        <?php msgFlash($msg, $msg_type); ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Địa chỉ email...">
            </div>

            <div class="form-group">
                <label for="">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu...">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=forgot">Quên mật khẩu</a></p>
            <p class="text-center"><a href="?module=auth&action=register">Đăng kí tài khoản</a></p>
        </form>
    </div>
</div>
<?php
layout('footer-login');
