<?php
require_once 'header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve order data and total price from the POST request
    $orderData = json_decode($_POST['orderData'], true);
    $totalPrice = $_POST['totalPrice'];

    // Fields for the 'details' table
    $fields = array(
        'full_name' => $_POST['full_name'],
        'number_phone' => $_POST['number_phone'],
        'price' => $totalPrice,
        'status_pay' => '0',
        'file' => '',
        'data_type' => 'shirt'
    );

    // Insert into the 'details' table
    $insert = $db->insert('details', $fields);
    if ($insert) {
        $insertId = $db->db->insert_id;

        // Insert each item into the 'order_shirt_items' table
        foreach ($orderData as $item) {
            $fields = array(
                'details_id' => $insertId,
                'size' => $item['size'],
                'amount' => $item['quantity']
            );
            $insertItem = $db->insert('order_shirt_items', $fields);
        }
        alert('บันทึกข้อมูลสำเร็จ');
        redirect('ctc_shirt_confirm.php?id=' . $insertId);
    } else {
        echo "Error inserting order details";
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
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            margin-bottom: 20px;
        }

        .form-section {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            margin-top: 20px;
        }

        .footer h6,
        .footer p {
            margin: 0;
        }

        .btn-custom {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn-custom.btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-custom.btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-custom:hover {
            opacity: 0.9;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .size-section {
            display: flex;
            flex-direction: column;
        }

        .size-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .size-item input[type="checkbox"] {
            margin-right: 10px;
        }

        .size-item .form-control {
            width: 50%;
            max-width: 200px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-center mb-4">
            <img src="../assets/shirt68year.png" class="img-fluid" alt="Shirt Image">
        </div>
        <form action="" method="POST" onsubmit="return validateAndSubmitOrderData()">
            <div class="form-section mx-auto col-md-8">
                <div class="row">
                    <div class="col-md-12 size-section">
                        <div class="size-item">
                            <input type="checkbox" class="form-check-input" id="sizeSS">
                            <label class="form-check-label me-2" for="sizeSS">SS</label>
                            <input type="number" class="form-control" placeholder="จำนวน" min="0" aria-label="SS" id="qtySS">
                        </div>
                        <div class="size-item">
                            <input type="checkbox" class="form-check-input" id="sizeS">
                            <label class="form-check-label me-2" for="sizeS">S</label>
                            <input type="number" class="form-control" placeholder="จำนวน" min="0" aria-label="S" id="qtyS">
                        </div>
                        <div class="size-item">
                            <input type="checkbox" class="form-check-input" id="sizeM">
                            <label class="form-check-label me-2" for="sizeM">M</label>
                            <input type="number" class="form-control" placeholder="จำนวน" min="0" aria-label="M" id="qtyM">
                        </div>
                        <div class="size-item">
                            <input type="checkbox" class="form-check-input" id="sizeL">
                            <label class="form-check-label me-2" for="sizeL">L</label>
                            <input type="number" class="form-control" placeholder="จำนวน" min="0" aria-label="L" id="qtyL">
                        </div>
                        <div class="size-item">
                            <input type="checkbox" class="form-check-input" id="sizeXL">
                            <label class="form-check-label me-2" for="sizeXL">XL</label>
                            <input type="number" class="form-control" placeholder="จำนวน" min="0" aria-label="XL" id="qtyXL">
                        </div>
                        <div class="size-item">
                            <input type="checkbox" class="form-check-input" id="size2L">
                            <label class="form-check-label me-2" for="size2L">2L</label>
                            <input type="number" class="form-control" placeholder="จำนวน" min="0" aria-label="2L" id="qty2L">
                        </div>
                    </div>
                </div>
                <center>
                    <p class="mt-3">จำนวนเงิน: <span id="totalAmount">0</span> บาท</p>
                </center>
                <input type="hidden" name="orderData" id="orderData">
                <input type="hidden" name="totalPrice" id="totalPrice">
                <div class="btn-container mt-4">
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            สั่งซื้อเสื้อ
                        </button>
                    </div>

                    <br>

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
                </div>
            </div>
        </form>
    </div>


    <script>
        const pricePerShirt = 250;

        // Function to update the total amount
        function updateTotal() {
            let total = 0;

            document.querySelectorAll('.size-item').forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                const quantityInput = item.querySelector('input[type="number"]');

                if (checkbox.checked) {
                    const quantity = parseInt(quantityInput.value) || 0;
                    total += quantity * pricePerShirt;
                }
            });

            document.getElementById('totalAmount').textContent = total;
        }

        // Attach event listeners to all quantity inputs
        document.querySelectorAll('.size-item input[type="number"]').forEach(input => {
            input.addEventListener('input', updateTotal);
        });

        // Attach event listeners to all checkboxes
        document.querySelectorAll('.size-item input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateTotal);
        });

        // Function to validate and gather shirt sizes and quantities
        function validateAndSubmitOrderData() {
            const orderData = [];
            let isValid = false;

            document.querySelectorAll('.size-item').forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                const quantityInput = item.querySelector('input[type="number"]');

                if (checkbox.checked) {
                    const size = checkbox.id.replace('size', '');
                    const quantity = parseInt(quantityInput.value) || 0;
                    if (quantity > 0) {
                        orderData.push({
                            size,
                            quantity
                        });
                        isValid = true;
                    }
                }
            });

            if (!isValid) {
                alert('กรุณาเลือกขนาดและจำนวนเสื้อ');
                return false; // Prevent form submission
            }

            document.getElementById('orderData').value = JSON.stringify(orderData);
            document.getElementById('totalPrice').value = document.getElementById('totalAmount').textContent;
            return true; // Allow form submission
        }

        updateTotal();
    </script>
    <?php
    include '../footer_ctc.html';
    ?>
    <script src="../js/bootstrap.bundle.js"></script>

</body>

</html>