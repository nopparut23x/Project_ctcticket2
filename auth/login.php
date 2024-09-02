<?php
require_once 'header.php';

if (isset($_POST['login'])) {

    $password = md5($_POST['password']);
    $where = array(
        'email' => $_POST['email'],
        'password' => $password,
    );
    $log = $db->selectwhere('users', $where);
    foreach ($log as $row);
    if (empty($log[0])) {
        alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง');
        redirect('login.php');
    } else {
        $_SESSION['id'] = $row['user_id'];
        alert('เข้าสู่ระบบ');
        redirect('../admin/');
    }
}

?>

<body>
    <div class="banner">
        <div class="container-sm d-flex justify-content-center align-items-center">
            <img src="../assets/image/ctc_banner.jpg" alt="">
        </div>
    </div>
    <br>
    <div class="d-flex flex-column mb-3 justify-content-center align-items-center text-primary-emphasis">
        <div class="p-2">
            <h5>ระบบจองบัตรและเสื้อที่ระลึก</h5>
        </div>
        <div class="p-2">
            <h6>คืนสู่เหย้า รั้ว น้ำเงิน-ขาว 86 ปี วิทยาลัยเทคนิคชัยภูมิ</h6>
        </div>
    </div>


    <div class="card w-50 m-auto">
        <div class="card-body">
            <h2 class="text-center">

                เข้าสู่ระบบผู้จัดการ
            </h2>
            <br>
            <main class="form-signin w-50 m-auto">
                <form method="post">
                    <div class="form-floating my-2">
                        <input type="text" class="form-control" id="username" name="email" placeholder="email" required>
                        <label for="username">อีเมล์</label>
                    </div>
                    <div class="form-floating my-2">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password">รหัสผ่าน</label>
                    </div>
                    <button class="btn btn-primary w-100 py-2 " type="submit" name="login" id="submit">เข้าสู่ระบบ</button>
                </form>
            </main>
        </div>
    </div>
    <hr>
    <?php
    include '../footer_ctc.html';
    ?>
</body>

</html>