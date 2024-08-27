<?php
require_once 'header.php';

// ค้นหาข้อมูลตาม input
$search = isset($_POST['search']) ? $_POST['search'] : '';
$where = array(
    'details_id' => $search,
    'full_name' => $search,
    'number_phone' => $search,
);
$select = $db->selectwhere_or('details', $where);

// เตรียมข้อมูลสำหรับการแสดงผล
$order_data = [];
if (!empty($select)) {
    foreach ($select as $row) {
        $where_order = array('details_id' => $row['details_id']);
        $order_select = $db->selectwhere('order_shirt_items', $where_order);

        $shirt_details = [];
        foreach ($order_select as $row_order) {
            $shirt_details[] = $row_order['size'] . ' (' . $row_order['amount'] . ' ชิ้น)';
        }
        $order_data[] = [
            'details_id' => $row['details_id'],
            'full_name' => $row['full_name'],
            'number_phone' => $row['number_phone'],
            'price' => $row['price'],
            'status_pay' => $row['status_pay'],
            'shirts' => implode(', ', $shirt_details),
            'data_type' => $row['data_type'],
            'file' => $row['file'],
            'timestamp' => $row['time_reservation'] // Assuming you have this field in your DB
        ];
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
    <p class="mt-5 ms-5">โปรดกรอกข้อมูลการสั่งซื้อ โดยค้นหาจากชื่อ หรือรหัสการสั่งซื้อ เเละเบอร์โทรศัพท์ก็ได้</p>
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

    <?php if (!empty($order_data)) : ?>
        <?php foreach ($order_data as $data) :
            if ($data['data_type'] == 'shirt') : ?>
                <div class="container mt-5">
                    <div class="card">
                        <div class="card-body">
                            <!-- เวลาการจองที่มุมซ้ายบนของ card -->
                            <p class="text-muted small"><?php echo $data['timestamp']; ?></p>
                            <div class="d-inline-flex">
                                <div class="mt-2 ms-1">
                                    <p>หมายเลขการสั่งซื้อ : 00<?php echo $data['details_id'] ?></p>
                                    <p>ชื่อผู้สั่งซื้อ : <?php echo $data['full_name'] ?></p>
                                    <p>เสื้อ : <?php echo $data['shirts'] ?></p>
                                    <p>ราคารวม : <?php echo $data['price'] ?> บาท</p>
                                </div>
                                <div class="mt-5 ms-1">
                                    <p>เบอร์โทร : <?php echo $data['number_phone'] ?></p>
                                </div>
                            </div>
                            <center>
                                <div class="mt-5 col-md-2">
                                    <?php
                                    if ($data['status_pay'] == 0) {
                                        echo '<h4 class="bg-secondary text-center rounded-pill p-2">ยังไม่ได้ชำระเงิน</h4>';
                                    } elseif ($data['status_pay'] == 1) {
                                        echo '<h4 class="bg-warning text-center rounded-pill p-2">รอตรวจสอบ</h4>';
                                        echo '<button class="btn btn-link" onclick="showEvidenceModal(\'' . '../' . $data['file'] . '\')">หลักฐานการชำระเงิน</button>';
                                    } elseif ($data['status_pay'] == 2) {
                                        echo '<h4 class="bg-success text-center rounded-pill p-2">ชำระเงินสำเร็จ</h4>';
                                        // ปุ่มดาวน์โหลดรายละเอียด
                                        echo '<a class="btn btn-success mt-3" href="print_shirt.php?id=' . $data['details_id'] . '">
            <h6>ดาวน์โหลดรายละเอียด</h6>
          </a>';
                                    }
                                    ?>
                                </div>
                                <div class="mt-5">
                                    <?php if ($data['status_pay'] == 0) : ?>
                                        <a class="btn btn-warning" href="ctc_shirt_confirm.php?id=<?php echo $data['details_id'] ?>">
                                            <h6>ชำระเงิน</h6>
                                        </a>
                                    <?php else : ?>
                                        <a class="btn btn-primary" href="shirt_order.php">
                                            <h6>สั่งเสื้อเพิ่ม</h6>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
                <br>
        <?php
            endif;
        endforeach; ?>
    <?php endif; ?>

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
    <?php
    include '../footer_ctc.html';
    ?>
    <script>
        function showEvidenceModal(imageSrc) {
            document.getElementById('paymentEvidenceImage').src = imageSrc;
            var modal = new bootstrap.Modal(document.getElementById('paymentEvidenceModal'));
            modal.show();
        }
    </script>
</body>

</html>