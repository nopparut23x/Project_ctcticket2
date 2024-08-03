<?php
require_once 'header.php';

// เปิดการแสดงข้อผิดพลาด
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ตรวจสอบว่า id ถูกต้องหรือไม่
$details_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($details_id > 0) {
    // ดึงข้อมูลการจองจากฐานข้อมูล
    $where = array('details_id' => $details_id);
    $reservation_data = $db->selectwhere('details', $where);

    if (!empty($reservation_data)) {
        $data = $reservation_data[0];

        // ดึงข้อมูลการจองโต๊ะ
        $where_reservation = array('details_id' => $details_id);
        $reservation_select = $db->selectwhere('reservation_items', $where_reservation);

        $table_numbers = [];
        $zones = [];

        foreach ($reservation_select as $row_reservation) {
            $where_table = array('table_id' => $row_reservation['table_id']);
            $selecttable = $db->selectwhere('table_re', $where_table);

            foreach ($selecttable as $row_table) {
                $table_numbers[] = $row_table['table_number'];

                $where_zone = array('zone_id' => $row_table['zone_id']);
                $selectzone = $db->selectwhere('zone_table', $where_zone);

                foreach ($selectzone as $row_zone) {
                    $zones[] = $row_zone['zone_name'];
                }
            }
        }

        // กำหนดขนาดภาพ
        $width = 800;
        $height = 600;
        $image = imagecreatetruecolor($width, $height);

        if ($image === false) {
            die('ไม่สามารถสร้างภาพได้');
        }

        // กำหนดสีพื้นหลัง (ไล่ระดับสีฟ้า)
        $background_color_start = imagecolorallocate($image, 173, 216, 230); // สีฟ้าอ่อน
        $background_color_end = imagecolorallocate($image, 135, 206, 250); // สีฟ้าเข้ม

        for ($i = 0; $i < $height; $i++) {
            $color = imagecolorallocate($image,
                ($background_color_start >> 16) + ($i * (($background_color_end >> 16) - ($background_color_start >> 16)) / $height),
                (($background_color_start >> 8) & 0xFF) + ($i * (((($background_color_end >> 8) & 0xFF) - (($background_color_start >> 8) & 0xFF)) / $height)),
                ($background_color_start & 0xFF) + ($i * (($background_color_end & 0xFF) - ($background_color_start & 0xFF)) / $height)
            );
            imageline($image, 0, $i, $width, $i, $color);
        }

        // กำหนดสีสำหรับกรอบและลวดลาย
        $border_color = imagecolorallocate($image, 0, 102, 204); // สีฟ้าสำหรับกรอบ
        $header_color = imagecolorallocate($image, 0, 51, 102); // สีฟ้ามืดสำหรับหัวข้อ
        $text_color = imagecolorallocate($image, 0, 0, 0); // สีดำสำหรับข้อความ

        // กำหนดฟอนต์
        $font_path = 'assets/font/THSarabun.ttf'; // ใช้ฟอนต์ที่ถูกต้อง

        if (!file_exists($font_path)) {
            die('ฟอนต์ไม่พบที่เส้นทางที่ระบุ');
        }

        $font_size = 18;
        $header_font_size = 24;
        $margin = 30;
        $logo_x = $width - 170; // ปรับตำแหน่งโลโก้ให้เหมาะสม
        $logo_y = 20;
        $logo_width = 150; // ปรับขนาดโลโก้
        $logo_height = 150;

        // เพิ่มโลโก้ (ถ้ามี)
        if (file_exists('assets/logo.png')) {
            $logo = imagecreatefrompng('assets/logo.png');
            if ($logo === false) {
                die('ไม่สามารถโหลดโลโก้ได้');
            }
            // ใช้ imagecopyresampled เพื่อให้โลโก้แสดงในขนาดที่เหมาะสม
            imagecopyresampled($image, $logo, $logo_x, $logo_y, 0, 0, $logo_width, $logo_height, imagesx($logo), imagesy($logo));
            imagedestroy($logo);
        }

        // เพิ่มกรอบลวดลาย
        imagerectangle($image, 10, 10, $width - 10, $height - 10, $border_color);
        imageline($image, 10, 50, $width - 10, 50, $border_color); // เส้นกรอบด้านบน
        imageline($image, 10, $height - 50, $width - 10, $height - 50, $border_color); // เส้นกรอบด้านล่าง
        imageline($image, 50, 10, 50, $height - 10, $border_color); // เส้นกรอบด้านซ้าย
        imageline($image, $width - 50, 10, $width - 50, $height - 10, $border_color); // เส้นกรอบด้านขวา

        // เพิ่มหัวข้อ
        imagettftext($image, $header_font_size, 0, $margin, $margin + 40, $header_color, $font_path, "ใบเสร็จการจอง");

        // เพิ่มข้อความลงในภาพ
        imagettftext($image, $font_size, 0, $margin, $margin + 100, $text_color, $font_path, "หมายเลขการจองบัตร: 00{$data['details_id']}");
        imagettftext($image, $font_size, 0, $margin, $margin + 140, $text_color, $font_path, "ชื่อผู้จอง: {$data['full_name']}");
        imagettftext($image, $font_size, 0, $margin, $margin + 180, $text_color, $font_path, "โต๊ะ: " . implode(', ', $table_numbers));
        imagettftext($image, $font_size, 0, $margin, $margin + 220, $text_color, $font_path, "ค่าจองบัตร: {$data['price']}");
        imagettftext($image, $font_size, 0, $margin, $margin + 260, $text_color, $font_path, "เบอร์โทร: {$data['number_phone']}");
        imagettftext($image, $font_size, 0, $margin, $margin + 300, $text_color, $font_path, "โซน: " . implode(', ', $zones));

        // ส่งภาพเป็นไฟล์ JPG
        header('Content-Type: image/jpeg');
        header('Content-Disposition: attachment; filename="receipt_' . $details_id . '.jpg"');

        // ทำความสะอาด output buffer
        ob_clean();

        // ส่งภาพ
        imagejpeg($image, null, 100); // เพิ่มคุณภาพของภาพ

        // ทำความสะอาด
        imagedestroy($image);
    } else {
        die('ไม่พบข้อมูลการจอง');
    }
} else {
    die('ข้อมูลไม่ถูกต้อง');
}
?>
