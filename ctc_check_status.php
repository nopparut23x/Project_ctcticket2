<?php
require_once 'header.php';
$where = array(
  'details_id' => $_GET['id']
);
$select = $db->selectwhere('details', $where);

foreach ($select as $row);
$where_reservation = array(
  'details_id' => $row['details_id']
);
$reservation_select = $db->selectwhere('reservation_items', $where_reservation);
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
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CTC Ticket</title>
  <link rel="stylesheet" href="css/bootstrap.css">
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
          <div class="mt-5 col-md-2 ">
            <h4 class="bg-primary text-center rounded-pill p-2">รอตรวจสอบ</h4>
          </div>
          <div class="mt-5 ">
            <a class="btn btn-primary" href="CTCsit.php">
              <h6>จองที่นั่งเพิ่ม</h6>
            </a>
            <button class="btn btn-primary">
              <h6>ออกจากระบบ</h6>
            </button>
          </div>
        </center>
      </div>
    </div>
  </div>
  <div class="mb-1">
    <hr>
    <h6 class="text-center ">
      วิทยาลัยเทคนิคขัยภูมิ<br>
      ติดต่อ xxx-xxxxxxx
    </h6>
    <p class="small float-end me-4 mt-1">พัฒนาโดนแผนกวิชาเทคโนโลยีสารสนเทศ</p>
  </div>
</body>

</html>