<?php
/*
 * File này chưa các chức năng đăng nhập
 * */
if (!defined('_INCODE')) die('Access Deined...');
$data = ['pageTitle' => 'Đăng nhập hệ thống'];
layout('header-login', $data);

//$session = setSession('login', 'Unicode');
//var_dump($session);
//setFlashData('msg', 'Dang nhap thanh cong');
//echo getFlashData('msg');
//setFlashData('msg_test', 'Dang nhap thanh cong');
echo getFlashData('msg_test');
?>

<div class="row">
    <div class="col-6" style="margin: 20px auto;">
        <h3 class="text-center text-uppercase">Đăng nhập hệ thống</h3>
        <form action="" method="post">
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" placeholder="Địa chỉ email...">
            </div>

            <div class="form-group">
                <label for="">Mật khẩu</label>
                <input type="password" class="form-control" placeholder="Mật khẩu...">
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
