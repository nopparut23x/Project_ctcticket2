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
foreach ($shirt_select as $row_shirt) {
  $shirtInfo[] = $row_shirt['size'] . ' (' . ' จำนวน ' . $row_shirt['amount'] . ')';
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
            <p>หมายเลขการสั่งซื้อ : 00<?php echo $row['details_id'] ?></p>
            <p>ชื่อผู้จอง : <?php echo $row['full_name'] ?></p>

            <p>เสื้อ size : <?php echo implode(' , ', $shirtInfo) ?>
            </p>
            <p>ราคารวม : <?php echo $row['price'] . ' บาท ' ?></p>
          </div>
          <div class="mt-5 ms-1">
            <p>เบอร์โทร : <?php echo $row['number_phone'] ?></p>
          </div>
        </div>
        <center>
          <div class="mt-5 col-md-2 ">
            <h4 class="bg-secondary text-center rounded-pill p-2">รอตรวจสอบการชำระเงิน</h4>
          </div>
        </center>
        <div class="float-end me-4 ">

          <a href="shirt_order.php" class="btn btn-primary">
            <h6>ส่ังซื้อเพิ่มเติม</h6>
          </a>
        </div>

      </div>
    </div>
  </div>
  <?php
  include '../footer_ctc.html';
  ?>
</body>

</html>