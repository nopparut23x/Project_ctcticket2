<?php
require_once 'header.php';
if (empty($_GET['id'])) {
  header("Location:ctcticket_home.php");
}
$where = array(
  'details_id' => $_GET['id']
);
$select = $db->selectwhere('details', $where);

foreach ($select as $row);
$where_reservation = array(
  'details_id' => $row['details_id']
);
$reservation_select = $db->selectwhere('order_table_items', $where_reservation);
foreach ($reservation_select as $row_reservation) {
  $where_table = array(
    'table_id' => $row_reservation['table_id']
  );
  $selecttable = $db->selectwhere('table_re', $where_table);
  foreach ($selecttable as $row_table) {
    $where_zone = array(
      'zone_id' => $row_table['zone_id']
    );
    $selectzone = $db->selectwhere('zone_table', $where_zone);
    foreach ($selectzone as $row_zone)
      $zone = $row_zone['zone_name'];

    $table[] = $row_table['table_number'];
  }
}

$where = array(
  'details_id' => $_GET['id']
);
$select = $db->selectwhere('details', $where);
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
    redirect("ctc_check_status.php?id=" . $row['details_id']);
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
            <p><b>หมายเลขการจองบัตร</b> : 00<?php echo $row['details_id'] ?></p>
            <p><b>ชื่อผู้จอง</b> : <?php echo $row['full_name'] ?></p>

            <p><b>โต๊ะ</b> :<?php echo implode(' , ', $table) ?>
            </p>
            <p><b>ค่าจองบัตร</b> : <?php echo $row['price'] ?></p>
          </div>
          <div class="mt-5 ms-1">
            <p><b>เบอร์โทร</b> : <?php echo $row['number_phone'] ?></p>
            <p><b>โซน</b> : <?php echo $zone ?></p>
          </div>
        </div>
        <hr>

        <center>
          <img src="../assets/image/logo_ktb1.webp" width="50px" height="50px">
          <h5 class="mt-3"><b>ธนาคารกรุงไทย</b> </h5>
          <p><b>เลขที่บัญชี</b>: 986-4-09952-3</p>
          <p><b>ชื่อบัญชี</b> : เงินสวัสดิการนักเรียน นักศึกษาวิทยาลัยเทคนิคชัยภูมิ</p>
          <br>
        </center>
        <form enctype="multipart/form-data" method="post">
          <div class="ms-3 col-md-4 mb-5">
            <p>เมื่อชำระเงินแล้วโปรแนบสลิปการชำระเงิน</p>
            <input type="file" class="form-control" name="image" required>
          </div>
          <div class="float-end me-4 ">

            <a href="../index.php" class="btn btn-warning"> ชำระเงินภายหลัง</a>

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