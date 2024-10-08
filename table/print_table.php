<?php
require_once 'header.php';

// Fetch details from the database
$where = array('details_id' => $_GET['id']);
$select = $db->selectwhere('details', $where);

foreach ($select as $row);

$where_reservation = array('details_id' => $row['details_id']);
$reservation_select = $db->selectwhere('order_table_items', $where_reservation);

$table = [];
foreach ($reservation_select as $row_reservation) {
    $where_table = array('table_id' => $row_reservation['table_id']);
    $selecttable = $db->selectwhere('table_re', $where_table);
    foreach ($selecttable as $row_table) {
        $where_zone = array('zone_id' => $row_table['zone_id']);
        $selectzone = $db->selectwhere('zone_table', $where_zone);
        foreach ($selectzone as $row_zone)
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
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style>
        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 1cm;
            }

            /* Hide the URL from printing */
            a[href]:after {
                content: "";
            }

            #downloadButton {
                display: none;
                /* Hide the button during print */
            }


        }
    </style>
    <script>
        function printAndHide() {
            document.getElementById('downloadButton').style.display = 'none'; // Hide the button
            window.print(); // Open print dialog
        }
    </script>
</head>

<body>
    <div class="container">
        <p class="mt-5 ms-4">โปรดตรวจสอบข้อมูลให้ครบถ้วน</p>
        <div class="card">
            <div class="card-body">
                <div class="d-inline-flex">
                    <div class="mt-2 ms-1">
                        <p class="text-muted small"><?php echo $row['time_reservation']; ?></p>

                        <p><b>หมายเลขบัตร</b> : 00<?php echo $row['details_id'] ?></p>
                        <p><b>ชื่อผู้จอง</b> : <?php echo $row['full_name'] ?></p>
                        <p><b>โต๊ะ</b> : <?php echo implode(' , ', $table) ?></p>
                        <p><b>ค่าจองบัตร</b> : <?php echo $row['price'] ?></p>
                    </div>

                    <div class="mt-4 ms-4">
                        <br>
                        <p><b>เบอร์โทร</b> : <?php echo $row['number_phone'] ?></p>
                        <p><b>โซน</b> : <?php echo $zone ?></p>
                    </div>
                </div>
                <div class="float-end me-4">
                    <button id="downloadButton" onclick="printAndHide()" type="button" class="btn btn-primary">
                        <h6>ดาวน์โหลด</h6>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
    include '../footer_ctc.html';
    ?>
</body>

</html>