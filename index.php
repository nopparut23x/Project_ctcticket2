<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTC 86 Years</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .banner img {
            width: 100%;
            height: auto;
        }

        .btn-custom {
            margin: 0 auto;
            width: auto;
            padding: 0.5rem 1rem;
            white-space: nowrap;
        }

        .message-ctc p {
            color: #184488;
            text-align: center;
            margin: 0;
        }

        .items-ticket .col-12 {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1rem;
        }

        .items-ticket img {
            width: 100%;
            max-width: 300px;
            height: auto;
            object-fit: cover;
        }

        .btn-wrapper {
            margin-top: 1rem;
        }

        @media (max-width: 576px) {
            .btn-custom {
                width: 100%;
            }

            .items-ticket .col-12 {
                margin-bottom: 1.5rem;
            }

            .message-ctc p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="banner">
        <div class="container-md d-flex justify-content-center align-items-center">
            <img src="assets/image/ctc_banner.jpg" alt="CTC Banner">
        </div>
    </div>
    <br>
    <div class="content m-5">
        <div class="container-md d-block justify-content-center align-items-center">
            <div class="message-ctc mb-4">
                <p>ระบบจองบัตรและเสื้อที่ระลึก</p>
                <p>86 ปี วิทยาลัยเทคนิคชัยภูมิ คืนสู่เหย้า รั้ว น้ำเงิน-ขาว</p>
            </div>
            <div class="items-ticket">
                <div class="row">
                    <div class="col-12 col-md-6 text-center">
                        <img src="assets/image/banner_home.jpg" alt="Ticket Booking">
                        <div class="btn-wrapper">
                            <a href="table/CTCsit.php" class="btn btn-outline-primary mt-1 btn-custom">จองบัตร</a>
                            <a class="btn btn-outline-primary mt-1 btn-custom" href="table/ctc_check_status_success.php">
                                ตรวจสอบการจองบัตร
                            </a>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 text-center">
                        <img src="assets/image/ctc_shirt.png" alt="Order Shirt">
                        <div class="btn-wrapper">
                            <a href="shirt/shirt_order.php" class="btn btn-outline-primary mt-1 btn-custom">สั่งเสื้อ</a>
                            <a href="shirt/shirt_order_result.php" class="btn btn-outline-primary mt-1 btn-custom">
                                ตรวจสอบการสั่งซื้อ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer_ctc.html'; ?>
</body>

</html>