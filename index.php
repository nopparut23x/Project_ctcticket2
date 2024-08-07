<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTC 86 Years</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .btn-custom {
            margin: 0 auto;
            width: auto;
            padding: 0.5rem 1rem;
            white-space: nowrap;
        }

        .message-ctc p {
            color: #184488;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="banner">
        <div class="container-md d-flex justify-content-center align-items-center">
            <img src="assets/image/ctc_banner.jpg" alt="">
        </div>
    </div>
    <br>
    <div class="content m-5">
        <div class="container-md d-block justify-content-center align-items-center">
            <div class="message-ctc">
                <p>ระบบจองบัตรและเสื้อที่ระลึก</p>
                <p>86 ปี วิทยาลัยเทคนิคชัยภูมิ คืนสู่เหย้า รั้ว น้ำเงิน-ขาว</p>
            </div>
            <div class="items-ticket">
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="row">
                        <div class="col-6 text-center">
                            <img src="img/ctc_ticket.png" alt="">
                            <div class="container">
                                <div class="row">
                                    <a href="table/ctcticket_home.php" class="btn btn-outline-primary mt-1 btn-custom"> จองบัตร</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <img src="assets/image/ctc_shirt.png" alt="">
                            <div class="container">
                                <div class="row">
                                    <a href="shirt/ctcshirt_home.php" class="btn btn-outline-primary mt-1 btn-custom">สั่งเสื้อ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include 'footer_ctc.html';
    ?>
</body>

</html>