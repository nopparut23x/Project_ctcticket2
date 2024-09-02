<?php
require_once 'header.php';

// Fetch shirt orders
$where_shirt = array(
    'data_type' => 'shirt'
);
$shirt_orders = $db->selectwhere('details', $where_shirt);

// Handle delete and update actions
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        $where_delete = array('details_id' => $_GET['id']);
        $delete = $db->delete('details', $where_delete);
        $delete = $db->delete('order_shirt_items', $where_delete);

        if ($delete) {
            alert('ยกเลิกการสั่งซื้อเรียบร้อย');
            redirect("manager_shirt.php");
        }
    } elseif ($_GET['action'] == 'confirm' && isset($_GET['id'])) {
        $where_update = array('details_id' => $_GET['id']);
        $fields = array(
            'status_pay' => 2,
            'user_id' => $_SESSION['id']
        );
        $update = $db->update('details', $fields, $where_update);

        if ($update) {
            alert('ตรวจสอบการสั่งซื้อเรียบร้อย');
            redirect("manager_shirt.php");
        }
    }
}

// Calculate total quantities by size and color
$size_totals = [];
foreach ($shirt_orders as $order) {
    $where_order_items = array('details_id' => $order['details_id']);
    $order_items = $db->selectwhere('order_shirt_items', $where_order_items);

    foreach ($order_items as $item) {
        $size = $item['size'];
        $color = $item['shirt_color']; // Assuming 'shirt_color' holds color information
        $amount = $item['amount'];

        if (!isset($size_totals[$size])) {
            $size_totals[$size] = [
                'w' => 0, // White shirts
                'b' => 0  // Blue shirts
            ];
        }

        $size_totals[$size][$color] += $amount;
    }
}
?>


<body>
    <div class="container mt-4">
        <h3>รายการสั่งซื้อเสื้อที่รอตรวจสอบ</h3>
        <div class="table-responsive">
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
                        <th>ผู้ตรวจสอบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($shirt_orders)) : ?>
                        <?php foreach ($shirt_orders as $order) : ?>
                            <?php
                            // Fetch related shirt order items
                            $where_order_items = array('details_id' => $order['details_id']);
                            $order_items = $db->selectwhere('order_shirt_items', $where_order_items);

                            $user_admin = "";
                            // Fetch user administration
                            if (isset($order['user_id'])) {
                                $where_user = array('user_id' => $order['user_id']);
                                $user = $db->selectwhere('users', $where_user);
                                foreach ($user as $u) {
                                    $user_admin = $u['firstname'] . " " . $u['lastname'];
                                }
                            }

                            $shirt_details = [];
                            foreach ($order_items as $item) {
                                $shirt_details[] = $item['size'] . ' (' . $item['amount'] . ' ตัว) - ' . (($item['shirt_color'] == 'w') ? 'สีขาว' : 'สีน้ำเงิน');
                            }
                            ?>
                            <tr>
                                <td>00<?php echo htmlspecialchars($order['details_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['number_phone']); ?></td>
                                <td><?php echo implode(', ', $shirt_details); ?></td>
                                <td><?php echo htmlspecialchars($order['price']); ?> บาท</td>
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
                                        <button class="btn btn-success btn-sm me-2 m-2" data-bs-toggle="modal" data-bs-target="#proofModal<?php echo htmlspecialchars($order['details_id']); ?>">ตรวจสอบ</button>
                                    <?php endif; ?>
                                    <a onclick="return confirm('คุณต้องการยกเลิกการสั่งซื้อหรือไม่')" href="?action=delete&id=<?php echo urlencode($order['details_id']); ?>" class="btn btn-danger btn-sm me-2 m-2">ยกเลิก</a>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($user_admin)) { ?>
                                        <b><?php echo htmlspecialchars($user_admin); ?></b>
                                    <?php
                                    } else {
                                        echo "<b class='text-danger'>ยังไม่มีผู้ตรวจสอบ</b>";
                                    }
                                    ?>
                                </td>
                            </tr>

                            <!-- Modal for proof -->
                            <div class="modal fade" id="proofModal<?php echo htmlspecialchars($order['details_id']); ?>" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="proofModalLabel">หลักฐานการชำระเงิน</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="../<?php echo htmlspecialchars($order['file']); ?>" class="img-fluid" alt="Proof Image">
                                        </div>
                                        <div class="modal-footer">
                                            <a href="?id=<?php echo urlencode($order['details_id']); ?>&action=confirm" class="btn btn-success">ยืนยันการตรวจสอบ</a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">ไม่มีข้อมูลที่รอตรวจสอบ</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Summary of shirt sizes and colors -->
        <div class="mt-4">
            <h4>สรุปจำนวนเสื้อที่สั่งซื้อ</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>ขนาดเสื้อ</th>
                            <th>จำนวนทั้งหมด</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($size_totals)) : ?>
                            <?php foreach ($size_totals as $size => $totals) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($size); ?></td>
                                    <td>สีขาว: <?php echo htmlspecialchars($totals['w']); ?> ตัว, สีน้ำเงิน: <?php echo htmlspecialchars($totals['b']); ?> ตัว</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="2" class="text-center">ไม่มีข้อมูล</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include '../footer_ctc.html'; ?>

    <!-- Include Bootstrap JS -->
</body>

</html>