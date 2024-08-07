<?php
require_once 'header.php';

// Fetch shirt orders
$where_shirt = array(
    'data_type' => 'shirt'
);
$shirt_orders = $db->selectwhere('details', $where_shirt);

// Handle delete and update actions
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $where_delete = array(
        'details_id' => $_GET['id']
    );
    $delete = $db->delete('details', $where_delete);
    $delete = $db->delete('order_shirt_items', $where_delete);

    if ($delete) {
        alert('ยกเลิกการสั่งซื้อเรียบร้อย');
        redirect("manager_shirt.php");
    }
}

if (isset($_GET['id']) && !isset($_GET['action'])) {
    $where_update = array(
        'details_id' => $_GET['id']
    );
    $fields = array(
        'status_pay' => 2
    );
    $update = $db->update('details', $fields, $where_update);
    if ($update) {
        alert('ตรวจสอบการสั่งซื้อเรียบร้อย');
        redirect("manager_shirt.php");
    }
}

// Calculate total quantities by size
$size_totals = [];
foreach ($shirt_orders as $order) {
    $where_order_items = array('details_id' => $order['details_id']);
    $order_items = $db->selectwhere('order_shirt_items', $where_order_items);
    foreach ($order_items as $item) {
        $size = $item['size'];
        $amount = $item['amount'];
        if (!isset($size_totals[$size])) {
            $size_totals[$size] = 0;
        }
        $size_totals[$size] += $amount;
    }
}
?>

<body>
    <div class="container mt-4">
        <h3>รายการสั่งซื้อเสื้อที่รอตรวจสอบ</h3>
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>หมายเลขการสั่งซื้อ</th>
                    <th>ชื่อผู้สั่งซื้อ</th>
                    <th>เบอร์โทร</th>
                    <th>เสื้อ</th>
                    <th>ราคารวม</th>
                    <th>สถานะการชำระเงิน</th>
                    <th>การกระทำ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($shirt_orders)) {
                    foreach ($shirt_orders as $order) {
                        // Fetch related shirt order items
                        $where_order_items = array('details_id' => $order['details_id']);
                        $order_items = $db->selectwhere('order_shirt_items', $where_order_items);

                        $shirt_details = [];
                        foreach ($order_items as $item) {
                            $shirt_details[] = $item['size'] . ' (' . $item['amount'] . ' ตัว)';
                        }
                ?>
                        <tr>
                            <td>00<?php echo $order['details_id']; ?></td>
                            <td><?php echo $order['full_name']; ?></td>
                            <td><?php echo $order['number_phone']; ?></td>
                            <td><?php echo implode(', ', $shirt_details); ?></td>
                            <td><?php echo $order['price']; ?> บาท</td>
                            <td>
                                <?php
                                if ($order['status_pay'] == 2) {
                                    echo '<span class="badge bg-success text-dark">ชำระเงินแล้ว</span>';
                                } elseif ($order['status_pay'] == 1) {
                                    echo '<span class="badge bg-warning text-dark">รอตรวจสอบ</span>';
                                } elseif ($order['status_pay'] == 0) {
                                    echo '<span class="badge bg-danger text-dark">ยังไม่ได้ชำระเงิน</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($order['file']) : ?>
                                    <a href="../<?php $order['file']; ?>" class="btn btn-success btn-sm">ตรวจสอบ</a>
                                    <a href="?id=<?php echo $order['details_id']; ?>" class="btn btn-warning btn-sm">ยืนยัน</a>
                                <?php endif; ?>
                                <a href="?action=delete&id=<?php echo $order['details_id']; ?>" class="btn btn-danger btn-sm">ยกเลิก</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="7" class="text-center">ไม่มีข้อมูลที่รอตรวจสอบ</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Summary of shirt sizes -->
        <div class="mt-4">
            <h4>สรุปจำนวนเสื้อที่สั่งซื้อ</h4>
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>ขนาดเสื้อ</th>
                        <th>จำนวนทั้งหมด</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($size_totals)) {
                        foreach ($size_totals as $size => $total) {
                    ?>
                            <tr>
                                <td><?php echo $size; ?></td>
                                <td><?php echo $total; ?> ตัว</td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="2" class="text-center">ไม่มีข้อมูล</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mb-1">
        <hr>
        <h6 class="text-center">
            วิทยาลัยเทคนิคชัยภูมิ<br>
            ติดต่อ xxx-xxxxxxx
        </h6>
        <p class="small float-end me-4 mt-1">พัฒนาโดยแผนกวิชาเทคโนโลยีสารสนเทศ</p>
    </div>
</body>

</html>