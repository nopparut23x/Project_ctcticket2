<?php
require_once 'header.php';
if (empty($_GET['id'])) {
  header("Location:ctcticket_home.php");
}
$where = array(
  'details_id' => $_GET['id']
);
$select = $db->selectwhere('details', $where);
if (isset($_POST['save'])) {
  if (!empty($_FILES['image'])) {
    $file = $db->upload($_FILES['image'], 'assets/image');
  }
  $fields = array(
    'file' => $file,
    'status_pay' => 1
  );
  $update = $db->update('details', $fields, $where);
  if ($update) {
    alert('บันทึกข้อมูลสำเร็จ');
    redirect("index.php");
  }
}
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
    foreach ($selectzone as $row_zone);
    $zone = $row_zone['zone_name'];

    $table[] = $row_table['table_number'];
  }
}
if (isset($_GET['action'])) {
  $where_delete = array(
    'details_id' => $_GET['id']
  );
  $delete = $db->delete('details', $where_delete);
  $delete = $db->delete('order_table_items', $where_delete);

  // Update table_status to 0 only for the tables that were pulled
  if ($delete) {
    foreach ($reservation_select as $row_reservation) {
      $where_update_table = array(
        'table_id' => $row_reservation['table_id']
      );
      $fields_update_table = array(
        'table_status' => 0
      );
      $db->update('table_re', $fields_update_table, $where_update_table);
    }

    alert('ยกเลิกการจองเรียบร้อย');
    redirect("../index.php");
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
            <p>หมายเลขการจองบัตร : 00<?php echo $row['details_id'] ?></p>
            <p>ชื่อผู้จอง : <?php echo $row['full_name'] ?></p>

            <p>โต๊ะ :<?php echo implode(' , ', $table) ?>
            </p>
            <p>ค่าจองบัตร : <?php echo $row['price'] ?></p>
          </div>
          <div class="mt-5 ms-1">
            <p>เบอร์โทร : <?php echo $row['number_phone'] ?></p>
            <p>โซน : <?php echo $zone ?></p>
          </div>
        </div>
        <center>
          <div class="mt-5 ">
            <a onclick="return confirm('ยืนยันการยกเลิกการจอง?')" class="btn btn-danger my-1" href="?action=delete&id=<?php echo $row['details_id'] ?>">
              <h6>ยกเลิกการจองที่นั่ง</h6>
            </a>
            <a class="btn btn-success my-1 " href="ctc_check_Order.php?action=confirm&id=<?php echo $row['details_id'] ?>">
              <h6>ดำเนินการต่อ</h6>
            </a>

          </div>
        </center>
      </div>
    </div>
  </div>
  <?php
  include '../footer_ctc.html';
  ?>
</body>

</html>