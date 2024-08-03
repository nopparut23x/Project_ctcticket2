<?php
require_once 'header.php';

$reservations = $db->select('details');
if (isset($_GET['action'])) {
    $where_delete = array(
        'details_id' => $_GET['id']
    );
    $delete = $db->delete('details', $where_delete);
    $delete = $db->delete('reservation_items', $where_delete);

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
        redirect("manager.php");
    }
}
if (isset($_GET['id'])) {
    $where_update = array(
        'details_id' => $_GET['id']
    );
    $fields = array(
        'status_pay' => 2
    );
    $update = $db->update('details', $fields, $where_update);
    if ($update) {
        alert('ตรวจสอบการจองเรียบร้อย');
        redirect("manager.php");
    }
}

?>


<body>
    <div class="container mt-4">
        <h3>รายการโต๊ะที่รอตรวจสอบ</h3>
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
                        $reservation_items = $db->selectwhere('reservation_items', $where_reservation);

                        $tables = [];

                        foreach ($reservation_items as $item) {
                            $where_table = array('table_id' => $item['table_id']);
                            $table_details = $db->selectwhere('table_re', $where_table);
                            foreach ($table_details as $table) {
                                $tables[] = $table['table_number'];

                                $where_zone = array('zone_id' => $table['zone_id']);
                                $zone_details = $db->selectwhere('zone_table', $where_zone);
                                foreach ($zone_details as $zone);
                                $zones = $zone['zone_name'];
                            }
                        }
                ?>
                        <tr>
                            <td>00<?php echo $reservation['details_id']; ?></td>
                            <td><?php echo $reservation['full_name']; ?></td>
                            <td><?php echo $reservation['number_phone']; ?></td>
                            <td><?php echo $zones ?></td>
                            <td><?php echo implode(', ', $tables); ?></td>
                            <td><?php echo $reservation['time_reservation']; ?></td>

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

                                <?php ?>
                            </td>
                            <td>
                                <a href="../<?php echo $reservation['file']; ?>" class="btn btn-success btn-sm">ตรวจสอบ</a>
                                <a href="?id=<?php echo $reservation['details_id']; ?>" class="btn btn-warning btn-sm">ยืนยัน</a>
                                <a href="?action=delete&id=<?php echo $reservation['details_id']; ?>" class="btn btn-danger btn-sm">ยกเลิก</a>
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
    </div>
    <div class="mb-1">
        <hr>
        <h6 class="text-center">
            วิทยาลัยเทคนิคขัยภูมิ<br>
            ติดต่อ xxx-xxxxxxx
        </h6>
        <p class="small float-end me-4 mt-1">พัฒนาโดนแผนกวิชาเทคโนโลยีสารสนเทศ</p>
    </div>
</body>

</html>