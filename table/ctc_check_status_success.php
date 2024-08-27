<?php
require_once 'header.php';

// ค้นหาข้อมูลตาม input
$search = isset($_POST['search']) ? $_POST['search'] : '';
$where = array(
  'details_id' => $search,
  'full_name' => $search,
  'number_phone' => $search
);
$select = $db->selectwhere_or('details', $where);

// เตรียมข้อมูลสำหรับการแสดงผล
$reservation_data = [];
if (!empty($select)) {
  foreach ($select as $row) {
    $where_reservation = array('details_id' => $row['details_id']);
    $reservation_select = $db->selectwhere('order_table_items', $where_reservation);

    $table_numbers = [];
    $zones = ''; // กำหนดค่าเริ่มต้นให้กับ $zones
    foreach ($reservation_select as $row_reservation) {
      $where_table = array('table_id' => $row_reservation['table_id']);
      $selecttable = $db->selectwhere('table_re', $where_table);

      foreach ($selecttable as $row_table) {
        $table_numbers[] = $row_table['table_number'];

        $where_zone = array('zone_id' => $row_table['zone_id']);
        $selectzone = $db->selectwhere('zone_table', $where_zone);

        if (!empty($selectzone)) {
          $zones = $selectzone[0]['zone_name'];
        }
      }
    }

    $reservation_data[] = [
      'details_id' => $row['details_id'],
      'full_name' => $row['full_name'],
      'number_phone' => $row['number_phone'],
      'price' => $row['price'],
      'status_pay' => $row['status_pay'],
      'tables' => implode(', ', $table_numbers),
      'zones' => $zones,
      'data_type' => $row['data_type'],
      'file' => $row['file']
    ];
  }
}

// Get the current date and time
$currentDateTime = date('d/m/Y H:i');
?>

<!-- HTML ส่วนที่แสดงผล -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CTC 86 Years</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
</head>

<body>
  <p class="mt-5 ms-5">โปรดกรอกข้อมูลผู้จอง โดยค้นหาจากชื่อ หรือรหัสการจองบัตร เเละเบอร์โทรศัพท์ก็ได้</p>
  <div class="card ms-5 me-5">
    <div class="card-body">
      <center>
        <!-- ฟอร์มค้นหา -->
        <form method="post">
          <div class="input-group">
            <input class="form-control me-2" type="search" placeholder="Search" name="search">
            <button class="btn btn-primary" type="submit" style="border-radius:24%">ค้นหา</button>
          </div>
        </form>
      </center>
    </div>
  </div>
  <p class="mt-4 ms-4">โปรดตรวจสอบข้อมูลก่อนยืนยันการชำระเงิน</p>

  <?php if (!empty($reservation_data)) : ?>
    <?php foreach ($reservation_data as $data) :
      if ($data['data_type'] == 'table') : ?>
        <div class="container mt-4">
          <div class="card">
            <div class="card-body">
              <!-- Display the current date and time -->
              <div class="text-start">
                <p>เวลา : <?php echo $currentDateTime; ?></p>
              </div>
              <div class="d-inline-flex">
                <div class="mt-2 ms-1">
                  <p>หมายเลขการจองบัตร : 00<?php echo $data['details_id'] ?></p>
                  <p>ชื่อผู้จอง : <?php echo $data['full_name'] ?></p>
                  <p>โต๊ะ : <?php echo $data['tables'] ?></p>
                  <p>ค่าจองบัตร : <?php echo $data['price'] ?></p>
                </div>
                <div class="mt-5 ms-1">
                  <p>เบอร์โทร : <?php echo $data['number_phone'] ?></p>
                  <p>โซน : <?php echo $data['zones'] ?></p>
                </div>
              </div>
              <center>
                <div class="mt-5 col-md-2">
                  <?php
                  if ($data['status_pay'] == 0) {
                    echo '<h4 class="bg-secondary text-center rounded-pill p-2">ยังไม่ได้ชำระเงิน</h4>';
                  } elseif ($data['status_pay'] == 1) {
                    echo '<h4 class="bg-primary text-center rounded-pill p-2">รอตรวจสอบ</h4>';
                    echo '<button class="btn btn-link" onclick="showEvidenceModal(\'' . '../' . $data['file'] . '\')">หลักฐานการชำระเงิน</button>';
                  } elseif ($data['status_pay'] == 2) {
                    echo '<h4 class="bg-success text-center rounded-pill p-2">ชำระเงินสำเร็จ</h4>';
                    // ปุ่มดาวน์โหลดรายละเอียด
                    echo '<a class="btn btn-success mt-3" href="print_table.php?id=' . $data['details_id'] . '">
            <h6>ดาวน์โหลดรายละเอียด</h6>
          </a>';
                  }
                  ?>
                </div>
                <div class="mt-5">
                  <?php if ($data['status_pay'] == 0) : ?>
                    <a class="btn btn-warning" href="ctc_check_Order.php?id=<?php echo $data['details_id'] ?>">
                      <h6>ชำระเงิน</h6>
                    </a>
                  <?php else : ?>
                    <a class="btn btn-primary" href="CTCsit.php">
                      <h6>จองที่นั่งเพิ่ม</h6>
                    </a>
                  <?php endif; ?>
                </div>
              </center>
            </div>
          </div>
        </div>
        <br>
    <?php endif;
    endforeach; ?>
  <?php endif; ?>
  <?php
  include '../footer_ctc.html';
  ?>

  <!-- Modal -->
  <div class="modal fade" id="paymentEvidenceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">หลักฐานการชำระเงิน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <center>
            <img id="paymentEvidenceImage" src="" alt="หลักฐานการชำระเงิน" class="img-fluid">
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript ฟังก์ชันสำหรับเปิด Modal -->
  <script>
    function showEvidenceModal(imageSrc) {
      document.getElementById('paymentEvidenceImage').src = imageSrc;
      var modal = new bootstrap.Modal(document.getElementById('paymentEvidenceModal'));
      modal.show();
    }
  </script>

</body>

</html>