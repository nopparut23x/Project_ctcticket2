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
foreach ($shirt_select as $row_shirt) {
    $shirtInfo[] = $row_shirt['size'] . ' (' . ' จำนวน ' . $row_shirt['amount'] . ')';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTC 86 Years</title>
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
                <p class="text-muted small"><?php echo $row['time_reservation']; ?></p>
                <div class="d-inline-flex">
                    <div class="mt-2 ms-1">
                        <p><b>หมายเลขการสั่งซื้อ</b> : 00<?php echo $row['details_id'] ?></p>
                        <p><b>ชื่อผู้จอง</b> : <?php echo $row['full_name'] ?></p>

                        <p><b>เสื้อ size</b> : <?php echo implode(' , ', $shirtInfo) ?>
                        </p>
                        <p><b>ราคารวม</b> : <?php echo $row['price'] . ' บาท ' ?></p>
                    </div>
                    <div class="mt-2 ms-4">
                        <p><b>เบอร์โทร</b> : <?php echo $row['number_phone'] ?></p>
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