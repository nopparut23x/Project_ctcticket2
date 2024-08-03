<?php
// ปิดการแสดงข้อผิดพลาด
ini_set('display_errors', 0);

// เริ่ม output buffering
ob_start();

// รวมไฟล์ที่จำเป็น
require_once 'fpdf/fpdf.php';
require_once 'header.php'; // ตรวจสอบว่าไม่มีการส่งออกข้อมูล

// รับ ID การจองจาก URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ดึงข้อมูลการจองตาม ID
$where = array('details_id' => $id);
$select = $db->selectwhere('details', $where);

if (!empty($select)) {
    $row = $select[0];
    $where_reservation = array('details_id' => $row['details_id']);
    $reservation_select = $db->selectwhere('reservation_items', $where_reservation);

    $table_numbers = [];
    $zones = ''; // Initialize zones
    foreach ($reservation_select as $row_reservation) {
        $where_table = array('table_id' => $row_reservation['table_id']);
        $selecttable = $db->selectwhere('table_re', $where_table);

        foreach ($selecttable as $row_table) {
            $table_numbers[] = $row_table['table_number'];

            $where_zone = array('zone_id' => $row_table['zone_id']);
            $selectzone = $db->selectwhere('zone_table', $where_zone);

            if (!empty($selectzone)) {
                $zones = $selectzone[0]['zone_name'];
            }
        }
    }

    // สร้าง PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->AddFont('THSarabun', '', 'THSarabun.php');
    $pdf->SetFont('THSarabun', '', 16); // ใช้ฟอนต์ที่รองรับภาษาไทย

    $pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'รายละเอียดการจอง'), 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('THSarabun', '', 12);
    $pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'หมายเลขการจอง: ' . $row['details_id']), 0, 1);
    $pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'ชื่อผู้จอง: ' . $row['full_name']), 0, 1);
    $pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'เบอร์โทรศัพท์: ' . $row['number_phone']), 0, 1);
    $pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'โต๊ะ: ' . implode(', ', $table_numbers)), 0, 1);
    $pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'ราคา: ' . $row['price']), 0, 1);
    $pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'โซน: ' . $zones), 0, 1);

    $status = '';
    if ($row['status_pay'] == 0) {
        $status = 'ยังไม่จ่าย';
    } elseif ($row['status_pay'] == 1) {
        $status = 'รอตรวจสอบ';
    } elseif ($row['status_pay'] == 2) {
        $status = 'จ่ายแล้ว';
    }

    $pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'สถานะการชำระเงิน: ' . $status), 0, 1);

    // ส่งออก PDF
    ob_end_clean(); // ล้าง buffer ที่อาจมีข้อมูลออก
    $pdf->Output('D', 'reservation_details_' . $row['details_id'] . '.pdf');
} else {
    ob_end_clean(); // ล้าง buffer ก่อนแสดงข้อความข้อผิดพลาด
    echo 'ไม่พบข้อมูลการจอง!';
}
