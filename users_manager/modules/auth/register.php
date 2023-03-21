<?php
/*
 * Dang ki
 * */
if (!defined('_INCODE')) die('Access Deined...');
$data = ['pageTitle' => 'Đăng kí tài khoản'];
layout('header-login', $data);
//Xử lý đăng kí
if (isPost()) {
    $body = getBody();
    $errors= [];
    //validate họ tên: bắt buộc nhập, >=5 kí tự
    if (empty(trim($body['fullname']))) {
        $errors['fullname']['required'] = 'Họ tên bắt buộc phải nhập';
    }else {
        if (strlen(trim($body['fullname'])) < 5) {
            $errors['fullname']['min'] = 'Họ tên phải >= 5';
        }
    }

    //Validate phone : bắt buộc nhập, định dạng là số điện thoại
    if (empty(trim($body['phone']))) {
        $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập';
    }else {
        if (!isPhone(trim($body['phone']))) {
            $errors['phone']['format'] = 'Số điện thoại không đúng định dạng';
        }
    }

    //Validate email : bắt buộc nhập, định dạng email, email phải duy nhất
    if (empty(trim($body['email']))) {
        $errors['email']['required'] = 'Email bắt buộc phải nhập';
    }else {
        if (!isEmail(trim($body['email']))) {
            $errors['email']['format'] = 'Email không đúng định dạng';
        }else {
            //Kiểm tra email có tồn tại trong DB hay không
            $email = trim($body['email']);
            $sql = "SELECT id FROM users WHERE email = '$email'";
            if (getRows($sql) > 0) {
                $errors['email']['unique'] = 'Địa chỉ email đã tồn tại';
            }
        }
    }

    //Vadate Password : Mật khẩu bắt buộc phải nhập và >= 8 kí tự
    if (empty(trim($body['password']))) {
        $errors['password']['required'] = 'Password bắt buộc phải nhập';
    }else {
        if (strlen(trim($body['password'])) < 8) {
            $errors['password']['min'] = 'Password phải >= 8';
        }
    }

    //Validate nhập lại mật khẩu : Bắt buộc phải nhập, giống trường mật khẩu
    if (empty(trim($body['confirm_password']))) {
        $errors['confirm_password']['required'] = 'Confirm Password bắt buộc phải nhập';
    }else {
        if (trim($body['confirm_password']) != trim($body['password'])) {
            $errors['confirm_password']['match'] = 'Không khớp với Password';
        }
    }

    if (empty($errors)) {
//        setFlashData('msg', 'Đăng nhập thành công');
//        setFlashData('msg_type', 'success');
        $activeToken = sha1(uniqid().time());
        $dataInsert = [
            'fullname' => $body['fullname'],
            'email' => $body['email'],
            'phone' => $body['phone'],
            'password' => password_hash($body['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'createAt' => date('Y-m-d H:i:s')
        ];
        $statusInsert = insert('users', $dataInsert);
        if ($statusInsert) {
            //Tạo link kích hoạt tài khoản
            $linkActive = _WEB_HOST_ROOT.'?module=auth&action=active&token='.$activeToken;
            //Thiết lập gửi mail
            $subject = $body['fullname'].' vui lòng kích hoạt tài khoản';
            $content = 'Chào bạn '.$body['fullname'].'<br>';
            $content .= 'Vui lòng click vào link dưới đây để kích hoạt tài khoản'.'<br>';
            $content .= $linkActive.'<br>';
            $content .= 'Trân trọng!';

            //Tiến hành gửi mail
            $sendStatus = sendMail($body['email'], $subject, $content);
            if ($sendStatus) {
                setFlashData('msg', 'Đăng kí tài khoản thành công. Vui lòng 
                                kiểm tra email để kích hoạt tài khoản');
                setFlashData('msg_type', 'success');
            }else {
                setFlashData('msg', 'Hệ thống đang gặp sự cố. Vui lòng thử lại sau');
                setFlashData('msg_type', 'danger');
            }
        }else {
            setFlashData('msg', 'Hệ thống đang gặp sự cố. Vui lòng thử lại sau');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=auth&action=register');
    }else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('?module=auth&action=register');
    }
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>
    <div class="row">
        <div class="col-6" style="margin: 20px auto;">
            <h3 class="text-center text-uppercase">Đăng kí tài khoản</h3>
            <?php
                msgFlash($msg, $msg_type);
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Họ tên</label>
                    <input type="text" name="fullname" class="form-control" placeholder="Họ tên..."
                           value="<?php echo old($old, 'fullname') ?>">
                    <?php echo form_error('fullname', $errors, '<span class="error">', '</span>') ?>
                </div>

                <div class="form-group">
                    <label for="">Điện thoại</label>
                    <input type="text" name="phone" class="form-control" placeholder="Điện thoại..."
                           value="<?php echo old($old, 'phone') ?>">
                    <?php echo form_error('phone', $errors, '<span class="error">', '</span>') ?>
                </div>

                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Địa chỉ Email..."
                           value="<?php echo old($old, 'email') ?>">
                    <?php echo form_error('email', $errors, '<span class="error">', '</span>') ?>
                </div>

                <div class="form-group">
                    <label for="">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu...">
                    <?php echo form_error('password', $errors, '<span class="error">', '</span>') ?>
                </div>

                <div class="form-group">
                    <label for="">Nhập lại mật khẩu</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu...">
                    <?php echo form_error('confirm_password', $errors, '<span class="error">', '</span>') ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Đăng kí</button>
                <hr>
                <p class="text-center"><a href="?module=auth&action=login">Đăng nhập hệ thống</a></p>
            </form>
        </div>
    </div>
<?php
layout('footer-login');
