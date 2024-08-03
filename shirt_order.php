<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTC Ticket</title>
    <link rel="stylesheet" href="css/bootstrap.css">
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
            /* Adjust the max-width as needed */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">
                <img src="assets/logo.png" width="30" height="30" class="bg-white rounded-circle" alt="Logo">
                ระบบจองบัตรเข้าร่วมงาน
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">ตรวจสอบการจองบัตร</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link text-white" href="#">ยื่นหลักฐานการชำระเงิน</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="d-flex justify-content-center mb-4">
            <img src="assets/shirt68year.png" class="img-fluid" alt="Shirt Image">
        </div>
        <form action="">
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
                <div class="btn-container mt-4">
                    <button type="submit" class="btn btn-primary btn-custom">
                        <h6 class="mb-0">สั่งซื้อ</h6>
                    </button>
                    <button type="button" class="btn btn-secondary btn-custom">
                        <h6 class="mb-0">ยกเลิก</h6>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="footer text-center bg-light">
        <hr>
        <h6>วิทยาลัยเทคนิคขัยภูมิ<br>ติดต่อ xxx-xxxxxxx</h6>
        <p class="small mt-2">พัฒนาโดยแผนกวิชาเทคโนโลยีสารสนเทศ</p>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
    <script>
        // Define the price per shirt
        const pricePerShirt = 400;

        // Function to update the total amount
        function updateTotal() {
            let total = 0;

            // Iterate through each size
            document.querySelectorAll('.size-item').forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                const quantityInput = item.querySelector('input[type="number"]');

                if (checkbox.checked) {
                    const quantity = parseInt(quantityInput.value) || 0;
                    total += quantity * pricePerShirt;
                }
            });

            // Update the total amount in the UI
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

        // Initial update
        updateTotal();
    </script>
</body>

</html>