<?php
/*
 * Dang ki
 * */
if (!defined('_INCODE')) die('Access Deined...');
$data = ['pageTitle' => 'Đăng kí tài khoản'];
layout('header-login', $data);
?>
    <div class="row">
        <div class="col-6" style="margin: 20px auto;">
            <h3 class="text-center text-uppercase">Đăng kí tài khoản</h3>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Họ tên</label>
                    <input type="text" class="form-control" placeholder="Họ tên...">
                </div>

                <div class="form-group">
                    <label for="">Điện thoại</label>
                    <input type="text" class="form-control" placeholder="Điện thoại...">
                </div>

                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" placeholder="Địa chỉ Email...">
                </div>

                <div class="form-group">
                    <label for="">Mật khẩu</label>
                    <input type="password" class="form-control" placeholder="Mật khẩu...">
                </div>

                <div class="form-group">
                    <label for="">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control" placeholder="Nhập lại mật khẩu...">
                </div>

                <button type="submit" class="btn btn-primary btn-block">Đăng kí</button>
                <hr>
                <p class="text-center"><a href="?module=auth&action=login">Đăng nhập hệ thống</a></p>
            </form>
        </div>
    </div>
<?php
layout('footer-login');
