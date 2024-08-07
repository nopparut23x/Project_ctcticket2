<?php
require_once 'header.php';
$select = $db->select('zone_table');
?>

<head>
  <style>
    .dropbtn {
      background-color: #4CAF50;
      color: white;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }


    .dropdown {
      position: relative;
      display: inline-block;
    }


    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    /* ตัวอักษร link  */
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    /* สี dropdown โซน */
    .dropdown-content a:hover {
      background-color: #f1f1f1
    }

    /* dropdownmenu */
    .dropdown:hover .dropdown-content {
      display: block;
    }

    /* สีดรอปดาว dropdown */
    .dropdown:hover .dropbtn {
      background-color: #3e8e41;
    }
  </style>
</head>

<body>

  <p class="mt-3 ms-5">โปรดเลือกโซนที่นั่งที่ท่านต้องการด้วยการคลิกที่บริเวณโซนที่ท่านต้องการเพื่อทำรายการจอง</p>
  <center>
    <img src="../assets/seat.jpg" style="width:90%; hieght:auto; " class="col-md">
  </center>
  <center>
    <div class="dropdown m-5">
      <button class="dropbtn ms-5 rounded-4 ">เลือกโซน</button>
      <div class="dropdown-content ms-5 " style="position:sticky ">
        <?php
        foreach ($select as $row_zone) {
        ?>
          <a href="reservation.php?id=<?php echo $row_zone['zone_id'] ?>" role="button"> โซน <?php echo $row_zone['zone_name'] ?></a>
        <?php } ?>
      </div>
    </div>
  </center>

  <?php
  include '../footer_ctc.html';
  ?>
</body>
<script src="js/bootstrap.bundle.js"></script>

</html>