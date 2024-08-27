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

            /* Hide elements during print */
            #downloadButton {
                display: none;
                /* Hide the button during print */
            }

            .text_number,
            .text_table {
                display: none;
                /* Hide these elements during print */
            }
        }

        img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            position: relative;
            z-index: 1;
        }

        .text_number {
            margin-top: 10px;
            margin-left: 200px;
            color: #184175;
            font-weight: bold;
            font-size: 24px;
            z-index: 999;
            position: absolute;
        }

        .text_table {
            color: #184175;
            font-weight: bold;
            font-size: 24px;
            z-index: 999;
            position: absolute;
            margin-left: 1011px;
            margin-top: -59px;
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
    <p class="mt-4 ms-4">โปรดตรวจสอบข้อมูลก่อนยืนยันการชำระเงิน</p>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-inline-flex">
                    <div class="mt-2 ms-1">
                        <div class="text_number">
                            <?php echo htmlspecialchars($row['details_id']); ?>
                        </div>
                        <img src="../assets/image/bill.png" class="img-fluid">

                        <div class="text_table">
                            <p> <?php echo htmlspecialchars(implode(' , ', $table)); ?></p>
                        </div>
                        <br>

                        <p>โซน : <?php echo htmlspecialchars($zone); ?></p>
                    </div>
                </div>
                <div class="float-end">
                    <button id="downloadButton" onclick="printAndHide()" type="button" class="btn btn-primary">
                        <h6>ดาวน์โหลด</h6>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php include '../footer_ctc.html'; ?>
</body>

</html>