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
  $shirtInfo[] = $row_shirt['size'] . ' (' . ' จำนวน ' . $row_shirt['amount'] . ')';
  $shirt_color[] = $row_shirt['shirt_color'];
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
            <p><b>หมายเลขการสั่งซื้อ :</b> 00<?php echo $row['details_id'] ?></p>
            <p><b>ชื่อผู้จอง :</b> <?php echo $row['full_name'] ?></p>

            <p><b>เสื้อ size : </b><?php echo implode(' , ', $shirtInfo) ?>
            </p>
            <p><b>สี color</b> :
              <?php $color = implode(' , ', $shirt_color);
              echo ($color == 'w') ? 'สีขาว' : 'สีน้ำเงิน'; ?>
            </p>
            <p><b>ราคารวม :</b> <?php echo $row['price'] . ' บาท ' ?></p>
          </div>
          <div class="mt-5 ms-1">
            <p><b>เบอร์โทร :</b> <?php echo $row['number_phone'] ?></p>
          </div>
        </div>
        <center>
          <div class="mt-5 col-md-2 ">

          </div>
        </center>
        <div class="float-end me-4 ">
          <a href="../index.php" class="btn btn-success">
            กลับหน้าหลัก
          </a>
          <a href="shirt_order.php" class="btn btn-primary">
            ส่ังซื้อเพิ่มเติม
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