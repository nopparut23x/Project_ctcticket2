<?php
require_once 'header.php';
$select = $db->select('zone_table');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Zone</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
  <style>
    .zone-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      margin: 10px;
      transition: box-shadow 0.3s;
      cursor: pointer;
      text-align: center;
    }

    .zone-card:hover {
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    }

    .zone-card h5 {
      margin: 0;
      font-size: 18px;
      color: #333;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .image-container {
      margin: 20px 0;
    }

    .image-container img {
      width: 100%;
      height: auto;
      border-radius: 8px;
    }

    .text-center {
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <p class="mt-3 text-center">โปรดเลือกโซนที่นั่งที่ท่านต้องการโดยคลิกที่บัตรโซนที่ท่านต้องการเพื่อทำรายการจอง</p>

    <div class="image-container">
      <img src="../assets/seat.jpg" alt="Seating Plan">
    </div>

    <div class="text-center">
      <div class="row">
        <?php foreach ($select as $row_zone) : ?>
          <div class="col-md-4">
            <a href="reservation.php?id=<?php echo $row_zone['zone_id'] ?>" class="text-decoration-none">
              <div class="zone-card">
                <h5>โซน <?php echo $row_zone['zone_name'] ?></h5>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <?php include '../footer_ctc.html'; ?>

  <script src="js/bootstrap.bundle.js"></script>
</body>

</html>