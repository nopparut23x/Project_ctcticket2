<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.css">
  <title>CTC Ticket</title>
  <style>
    .header-container {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      margin-bottom: 40px;
    }

    .header-container img {
      width: 100px;
      margin-right: 20px;
    }

    .header-container h3,
    .header-container p {
      margin: 0;
    }

    .content-container {
      display: flex;
      flex-direction: row;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .content-container .item {
      width: 100%;
      max-width: 450px;
      text-align: center;
      margin: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 10px;
      box-sizing: border-box;
    }

    .content-container img {
      width: 100%;
      height: auto;
      max-height: 250px;
      margin-bottom: 15px;
    }

    .btn-custom {
      font-size: 1.5rem;
      padding: 10px 20px;
      border-radius: 50px;
      display: inline-block;
      width: 100%;
      max-width: 250px;
      text-align: center;
      line-height: 1.5;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      padding: 20px;
      background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
      .content-container {
        flex-direction: column;
        align-items: center;
      }
    }

    @media (max-width: 576px) {
      .header-container img {
        width: 80px;
      }

      .btn-custom {
        font-size: 1.2rem;
        padding: 8px 16px;
        max-width: 200px;
      }

      .footer {
        padding: 10px;
      }
    }
  </style>
</head>

<body>
  <div class="container header-container mt-5">
    <img src="img/logo1.png" alt="Logo">
    <div>
      <h3>ครบรอบ 86 ปี วิทยาลัยเทคนิคชัยภูมิ</h3>
      <p>The 86 years Anniversary Chaiyaphum</p>
      <p>Technical College</p>
    </div>
  </div>

  <div class="container content-container">
    <div class="item">
      <img src="img/ctc_ticket.png" alt="CTC Ticket">
      <a href="ctcticket_home.php" class="btn btn-primary btn-custom">
        จองบัตร
      </a>
    </div>

    <div class="item">
      <img src="assets/shirt68year.png" alt="Shirt">
      <a href="ctcshirt_home.php" class="btn btn-primary btn-custom">
        ซื้อเสื้อ
      </a>
    </div>
  </div>

  <div class="footer">
    <hr>
    <h6>
      วิทยาลัยเทคนิคชัยภูมิ<br>
      ติดต่อ xxx-xxxxxxx
    </h6>
    <p class="small mt-2">พัฒนาโดยแผนกวิชาเทคโนโลยีสารสนเทศ</p>
  </div>

</body>

</html>