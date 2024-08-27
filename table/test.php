<?php
require_once 'header.php';

$where_table = array(
    'data_type' => 'table'
);
$reservations = $db->selectwhere('details', $where_table);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($action == 'delete' && $id) {
        // Delete the reservation details and related table items
        $where_delete = array('details_id' => $id);
        // Fetch related table items to update their status
        $order_table_items = $db->selectwhere('order_table_items', $where_delete);

        foreach ($order_table_items as $item) {
            if (isset($item['table_id'])) { // Check if table_id exists
                $where_update_table = array('table_id' => $item['table_id']);
                $fields_update_table = array('table_status' => 0);
                $db->update('table_re', $fields_update_table, $where_update_table);
            }
        }
        $db->delete('details', $where_delete);
        $db->delete('order_table_items', $where_delete);



        alert('ยกเลิกการจองเรียบร้อย');
        redirect("manager_table.php");
    } elseif ($action == 'confirm' && $id) {
        $where_update = array('details_id' => $id);
        $fields = array('status_pay' => 2);
        $update = $db->update('details', $fields, $where_update);
        if ($update) {
            alert('ตรวจสอบการจองเรียบร้อย');
            redirect("manager_table.php");
        }
    }
}
?>

<body>
    <div class="container mt-4">
        <h3>รายการโต๊ะที่รอตรวจสอบ</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>หมายเลขการจองบัตร</th>
                        <th>ชื่อผู้จอง</th>
                        <th>เบอร์โทร</th>
                        <th>โซน</th>
                        <th>โต๊ะ</th>
                        <th>เวลา</th>
                        <th>สถานะการชำระเงิน</th>
                        <th>การกระทำ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($reservations)) {
                        foreach ($reservations as $reservation) {
                            // Fetch related table and zone details
                            $where_reservation = array('details_id' => $reservation['details_id']);
                            $order_table_items = $db->selectwhere('order_table_items', $where_reservation);

                            $tables = [];
                            $zones = "";

                            foreach ($order_table_items as $item) {
                                if (isset($item['table_id'])) { // Check if table_id exists
                                    $where_table = array('table_id' => $item['table_id']);
                                    $table_details = $db->selectwhere('table_re', $where_table);
                                    foreach ($table_details as $table) {
                                        $tables[] = $table['table_number'];

                                        if (isset($table['zone_id'])) { // Check if zone_id exists
                                            $where_zone = array('zone_id' => $table['zone_id']);
                                            $zone_details = $db->selectwhere('zone_table', $where_zone);
                                            foreach ($zone_details as $zone) {
                                                $zones = $zone['zone_name'];
                                            }
                                        }
                                    }
                                }
                            }
                    ?>
                            <tr>
                                <td>00<?php echo htmlspecialchars($reservation['details_id']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($reservation['number_phone']); ?></td>
                                <td><?php echo htmlspecialchars($zones); ?></td>
                                <td><?php echo htmlspecialchars(implode(', ', $tables)); ?></td>
                                <td><?php echo htmlspecialchars($reservation['time_reservation']); ?></td>
                                <td>
                                    <?php
                                    if ($reservation['status_pay'] == 2) {
                                        echo '<span class="badge bg-success text-dark">ชำระเงินแล้ว</span>';
                                    } elseif ($reservation['status_pay'] == 1) {
                                        echo '<span class="badge bg-warning text-dark">รอตรวจสอบ</span>';
                                    } elseif ($reservation['status_pay'] == 0) {
                                        echo '<span class="badge bg-danger text-dark">ยังไม่ได้ชำระเงิน</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($reservation['file']) : ?>
                                        <button class="btn btn-success btn-sm m-2" data-bs-toggle="modal" data-bs-target="#proofModal<?php echo htmlspecialchars($reservation['details_id']); ?>">ตรวจสอบ</button>
                                    <?php endif; ?>
                                    <a onclick="return confirm('คุณต้องการยกเลิกการจองหรือไม่?')" href="?action=delete&id=<?php echo urlencode($reservation['details_id']); ?>" class="btn btn-danger btn-sm m-2">ยกเลิก</a>
                                </td>
                            </tr>

                            <!-- Modal for proof -->
                            <div class="modal fade" id="proofModal<?php echo htmlspecialchars($reservation['details_id']); ?>" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="proofModalLabel">หลักฐานการชำระเงิน</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="../<?php echo htmlspecialchars($reservation['file']); ?>" class="img-fluid" alt="Proof Image">
                                        </div>
                                        <div class="modal-footer">
                                            <a href="?id=<?php echo urlencode($reservation['details_id']); ?>&action=confirm" class="btn btn-success">ยืนยันการตรวจสอบ</a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">ไม่มีข้อมูลที่รอตรวจสอบ</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    include '../footer_ctc.html';
    ?>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>