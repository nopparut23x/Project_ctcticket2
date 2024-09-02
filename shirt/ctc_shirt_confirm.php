<?php
require_once 'header.php';
if (empty($_GET['id'])) {
  header("Location:ctcshirt_home.php");
}
$where = array(
  'details_id' => $_GET['id']
);
$select = $db->selectwhere('details', $where);

foreach ($select as $row);
$where_shirt = array(
  'details_id' => $row['details_id']
);
$shirt_select = $db->selectwhere('order_shirt_items', $where_shirt);

// Create an array to hold size and amount information
$shirtInfo = array();
$shirt_color = array();
foreach ($shirt_select as $row_shirt) {
  $shirtInfo[] = $row_shirt['size'] . ' (' . $row_shirt['amount'] . ' ตัว ' . ')';
  $shirt_color[] = $row_shirt['shirt_color'];
}

if (isset($_POST['save'])) {
  if (!empty($_FILES['image'])) {
    $file = $db->upload($_FILES['image'], 'assets/image/evidence');
  }
  $fields = array(
    'file' => $file,
    'status_pay' => 1
  );
  $update = $db->update('details', $fields, $where);
  if ($update) {
    alert('บันทึกข้อมูลสำเร็จ');
    redirect("ctc_check_shirt_status.php?id=" . $row['details_id']);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CTC 86 Years</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
</head>

<body>
  <p class="mt-4 ms-4">โปรดตรวจสอบข้อมูลก่อนยืนยันการชำระเงิน</p>
  <div class="container">
    <div class="card">
      <div class="card-body">
        <div class="d-inline-flex">
          <div class="mt-2 ms-1">
            <p><b>หมายเลขการสั่งซื้อ</b> : 00<?php echo $row['details_id'] ?></p>
            <p><b>ชื่อผู้จอง</b> : <?php echo $row['full_name'] ?></p>

            <p><b>เสื้อ size</b> : <?php echo implode(' , ', $shirtInfo) ?>
            <p><b>สี color</b> :
              <?php $color = implode(' , ', $shirt_color);
              echo ($color == 'w') ? 'สีขาว' : 'สีน้ำเงิน'; ?>
            </p>
            <p><b>ราคารวม</b> : <?php echo $row['price'] . ' บาท ' ?></p>
          </div>
          <div class="mt-5 ms-1">
            <p><b>เบอร์โทร</b> : <?php echo $row['number_phone'] ?></p>
          </div>
        </div>
        <center>
          <img src="../assets/image/logo_ktb1.webp" width="50px" height="50px">
          <h5 class="mt-3"><b>ธนาคารกรุงไทย</b> </h5>
          <p><b>เลขที่บัญชี</b>: 986-4-09952-3</p>
          <p><b>ชื่อบัญชี</b> : เงินสวัสดิการนักเรียน นักศึกษาวิทยาลัยเทคนิคชัยภูมิ</p>
          <br>
        </center>
        <form action="" method="post" enctype="multipart/form-data">

          <div class="ms-3 col-md-4 mb-5">
            <p>เมื่อชำระเงินแล้วโปรแนบสลิปการชำระเงิน</p>
            <input type="file" class="form-control" name="image" required>
          </div>
          <div class="float-end me-4 ">
            <a href="shirt_order.php" class="btn btn-warning">ชำระเงินภายหลัง</a>
            <button name="save" type="submit" class="btn btn-primary">
              ยืนยัน
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
  <?php
  include '../footer_ctc.html';
  ?>
</body>

</html>