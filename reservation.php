<?php
require_once 'header.php';
$where = ['zone_id' => $_GET['id']];
$select = $db->selectwhere('table_re', $where);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check'])) {
    $totalItems = count($_POST['check']);
    $totalPrice = $totalItems * 2500;
    $fields_user = array(
        'full_name' => $_POST['full_name'],
        'number_phone' => $_POST['number_phone'],
        'price' => $totalPrice,
        'status_pay' => '0',
        'file' => '',
    );
    $insert2 = $db->insert('details', $fields_user);
    $insertId = $db->db->insert_id;

    foreach ($_POST['check'] as $value) {
        $fields = array(
            'details_id' => $insertId,
            'Numberphone_id' => $_POST['number_phone'],
            'table_id' => $value
        );
        $where_update = array('table_id' => $value);
        $fields_update = array('table_status' => 1);

        $update = $db->update('table_re', $fields_update, $where_update);
        $insert = $db->insert('reservation_items', $fields);
    }

    if ($insert) {
        alert('บันทึกข้อมูลสำเร็จ');
        redirect("ctc_check.php?id=" . $insertId);
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
    <script>
        function validateSelection() {
            const checkboxes = document.querySelectorAll('input[name="check[]"]');
            const selected = Array.from(checkboxes).some(checkbox => checkbox.checked);

            if (!selected) {
                alert('กรุณาเลือกโต๊ะอย่างน้อย 1 โต๊ะ');
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <img src="assets/seat.jpg" style="width:90%; height:auto;" class="col-md">

    <form method="POST" enctype="multipart/form-data" id="reservationForm" onsubmit="return validateSelection();">

        <div class="container mt-5">

            <div class="row">
                <?php foreach ($select as $row_table) { ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p>โต๊ะที่: <?php echo $row_table['table_number'] ?></p>
                                    <p>สถานะ:
                                        <?php if ($row_table['table_status'] == 0) { ?>
                                            <span class="badge bg-success" style="font-size: 10px;">ว่าง</span>
                                        <?php } else { ?>
                                            <span class="badge bg-danger" style="font-size: 10px;">ไม่ว่าง</span>
                                        <?php } ?>
                                    </p>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" name="check[]" value="<?php echo $row_table['table_id'] ?>" id="flexCheckDefault" <?php echo $row_table['table_status'] == 0 ? '' : 'disabled'; ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Button trigger modal -->
        <div class="text-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                ยืนยัน
            </button>
        </div>
        <br>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">รายละเอียด</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="text" name="full_name" required placeholder="ชื่อ-นามสกุล">
                        <br>
                        <input class="form-control" type="text" name="number_phone" required placeholder="เบอร์โทรศัพท์">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>