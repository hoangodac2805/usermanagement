<?php
if (!defined('_INCODE'))
    die('Access Dined...');
$data = ['pageTitle' => 'Đăng ký hệ thống'];
layout('header-login', $data);
if (isPost()) {
    //validate form
    $body = getBody(); // Lấy tất cả dữ liệu trong form;
    $errors = [];
    //Validate họ tên: Bắt buộc phải nhập, => 5 ký tự
    if (empty(trim($body['fullname']))) {
        $errors['fullname']['required'] = 'Họ tên bắt buộc phải nhập';
    } else {
        if (strlen(trim($body['fullname'])) < 5) {
            $errors['fullname']['min'] = 'Họ tên phải lớn hơn hoặc bằng 5 ký tự';
        }
    }
    // validate điện thoại
    if (empty(trim($body['phone']))) {
        $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập';
    } else {
        if (!isPhone(trim($body['phone']))) {
            $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ';
        }
    }
    //Validate email: Bắt buộc phải nhập, định dạng email, email phải là duy nhất
    if (empty(trim($body['email']))) {
        $errors['email']['required'] = 'Email bắt buộc phải nhập';
    } else {
        //kiểm tra email hợp lệ
        if (!isEmail(trim($body['email']))) {
            $errors['email']['isEmail'] = 'Email không hợp lệ';
        } else {
            //Kiểm tra email có tồn tại trong dtb hay chưa
            $email = trim($body['email']);
            $sql = "SELECT id FROM users where email = '$email'";
            if (getRows($sql) > 0) {
                $errors['email']['unique'] = 'Địa chỉ email đã tồn tại';
            }
        }
    }
    //Validate mật khẩu: Bắt buộc phải nhập, >= 8 ký tự;
    if (empty(trim($body['password']))) {
        $errors['password']['required'] = 'Password bắt buộc phải nhập';
    } else {
        if (strlen(trim($body['password'])) < 8) {
            $errors['password']['min'] = 'Password không được nhỏ hơn 8 ký tự';
        }
    }
    //validate nhập lại mật khẩu
    if (empty(trim($body['confirm_password']))) {
        $errors['confirm_password']['required'] = 'Xác nhận password bắt buộc phải nhập';
    } else {
        if (trim($body['password'] != trim($body['confirm_password']))) {
            $errors['confirm_password']['match'] = 'Mật khẩu không giống nhau';
        }
    }
    //Kiểm tra mảng errors
    if (empty($errors)) {
        //Không có lỗi xảy ra
        // setFlashData('msg', 'Validate thành công');
        // setFlashData('msg_type', 'success');

        $activeToken = sha1(uniqid() . time());
        $dataInsert = [
            'email' => $body['email'],
            'fullname' => $body['fullname'],
            'phone' => $body['phone'],
            'password' => password_hash($body['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'createdAt' => date('Y-m-d H:i:s')
        ];
        $insertStatus = insert('users', $dataInsert);
        if ($insertStatus) {
            //Tạo link kích hoạt
            $linkActive = _WEB_HOST_ROOT . '?module=auth&action=active&token=' . $activeToken;
            //Thiết lập gửi mail
            $subject = $body['fullname'] . ' vui lòng kích hoạt tài khoản';
            $content = '<h3 style="color:red;">Chào bạn ' . $body['fullname'] . '</h3>
        <br>
        <p>Vui lòng nhấn vào link dưới đây để kích hoạt tài khoản</p>
         <br>
          ' . $linkActive . '
          <br>
           <p>Trân trọng</p>
         ';
            // Tiến hành gửi mail
            $sendStatus = sendMail($body['email'], $subject, $content);
            if ($sendStatus) {
                setFlashData('msg', 'Đăng ký tài khoản thành công.Vui lòng kiểm tra email để kích hoạt tài khoản');
                setFlashData('msg_type', 'success');
            } else {
                setFlashData('msg', 'Hệ thống đang gặp sự cố. Vui lòng thử lại sau');
                setFlashData('msg_type', 'warning');
            }

        }

        // redirect('?module=auth&action=login');
    } else {
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('?module=auth&action=register');
    }

}
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>
<div class="row">
    <div class="col-6" style="margin: 20px auto">
        <h3 class="text-center text-uppercase">Đăng ký tài khoản mới</h3>
        <?php getMsg($msg, $msgType) ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="">Họ tên</label>
                <input name="fullname" type="text" class="form-control" placeholder="Họ tên"
                    value="<?php echo old('fullname', $old) ?>">
                <?php form_error('fullname', $errors) ?>
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input name="email" type="text" class="form-control" placeholder="Địa chỉ email"
                    value="<?php echo old('email', $old) ?>">
                <?php form_error('email', $errors) ?>
            </div>
            <div class="form-group">
                <label for="">Số điện thoại</label>
                <input name="phone" type="text" class="form-control" placeholder="0123456789"
                    value="<?php echo old('phone', $old) ?>">
                <?php form_error('phone', $errors) ?>
            </div>
            <div class="form-group">
                <label for="">Mật khẩu</label>
                <input name="password" type="password" class="form-control" placeholder="Mật khẩu"
                    value="<?php echo old('password', $old) ?>">
                <?php form_error('password', $errors) ?>
            </div>
            <div class="form-group">
                <label for="">Xác nhận mật khẩu</label>
                <input name="confirm_password" type="password" class="form-control" placeholder="Mật khẩu"
                    value="<?php echo old('confirm_password', $old) ?>">
                <?php form_error('confirm_password', $errors) ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=login">Đăng nhập hệ thống</a></p>
        </form>

    </div>
</div>

<?php

layout('footer-login');

?>