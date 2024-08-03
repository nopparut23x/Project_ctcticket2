<?php
require_once 'header.php';

// Fetch existing zones
$zones = $db->select('zone_table');

// Handle form submissions for adding tables and zones
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_table'])) {
        $table_number_start = $_POST['table_number'];
        $zone_id = $_POST['zone_id'];
        $table_count = $_POST['table_count'];

        for ($i = 0; $i < $table_count; $i++) {
            $fields = array(
                'table_number' => $table_number_start + $i,
                'zone_id' => $zone_id,
                'table_status' => 0
            );
            $db->insert('table_re', $fields);
        }
        alert('เพิ่มโต๊ะจำนวน ' . $table_count . ' สำเร็จ');
        redirect("add_table.php");
    } elseif (isset($_POST['add_zone'])) {
        $fields = array(
            'zone_name' => $_POST['zone_name']
        );
        $db->insert('zone_table', $fields);
        alert('เพิ่มโซนสำเร็จ');
        redirect("add_table.php");
    } elseif (isset($_POST['delete_selected'])) {
        $table_ids = $_POST['table_ids'] ?? [];

        if (!empty($table_ids)) {
            $where = "table_id IN (" . implode(',', array_map('intval', $table_ids)) . ")";
            $db->delete('table_re', $where);
            alert('ลบโต๊ะที่เลือกสำเร็จ');
        }
        redirect("add_table.php");
    } elseif (isset($_POST['delete_zone_tables'])) {
        $zone_id = $_POST['zone_id'];

        $where = array('zone_id' => $zone_id);
        $db->delete('table_re', $where);
        alert('ลบโต๊ะทั้งหมดในโซนสำเร็จ');
        redirect("add_table.php");
    }
}

// Filter tables based on selected zone
$selected_zone_id = isset($_GET['zone_id']) ? $_GET['zone_id'] : '';
if (!empty($selected_zone_id)) {
    $where = ['zone_id' => $selected_zone_id];
    $tables = $db->selectwhere('table_re', $where);
} else {
    $tables = $db->select('table_re');
}

if ($tables === false) {
    die('ไม่สามารถดึงข้อมูลโต๊ะได้');
}
?>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">จัดการโต๊ะและโซน</h2>

        <!-- Add Zone Form -->
        <form method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" name="zone_name" class="form-control" placeholder="กรอกชื่อโซน" required>
                <button type="submit" name="add_zone" class="btn btn-primary">เพิ่มโซน</button>
            </div>
        </form>

        <!-- Add Table Form -->
        <form method="POST" class="mb-4">
            <div class="input-group mb-3">
                <input type="text" name="table_number" class="form-control" placeholder="กรอกหมายเลขโต๊ะเริ่มต้น" required>
                <select name="zone_id" class="form-select" required>
                    <option value="" disabled selected>เลือกโซน</option>
                    <?php foreach ($zones as $zone) { ?>
                        <option value="<?php echo $zone['zone_id']; ?>"><?php echo $zone['zone_name']; ?></option>
                    <?php } ?>
                </select>
                <input type="number" name="table_count" class="form-control" placeholder="จำนวนโต๊ะ" min="1" required>
                <button type="submit" name="add_table" class="btn btn-primary">เพิ่มโต๊ะ</button>
            </div>
        </form>

        <!-- Zone Filter Form -->
        <form method="GET" class="mb-4">
            <div class="input-group">
                <select name="zone_id" class="form-select" onchange="this.form.submit()">
                    <option value="">ทุกโซน</option>
                    <?php foreach ($zones as $zone) { ?>
                        <option value="<?php echo $zone['zone_id']; ?>" <?php echo $selected_zone_id == $zone['zone_id'] ? 'selected' : ''; ?>>
                            <?php echo $zone['zone_name']; ?>
                        </option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn btn-primary">กรอง</button>
            </div>
        </form>

        <!-- Table Management -->
        <form method="POST">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>เลือก</th>
                        <th>หมายเลขโต๊ะ</th>
                        <th>โซน</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tables as $table) { ?>
                        <tr>
                            <td><input type="checkbox" name="table_ids[]" value="<?php echo $table['table_id']; ?>"></td>
                            <td><?php echo $table['table_number']; ?></td>
                            <td><?php
                                foreach ($zones as $zone) {
                                    if ($zone['zone_id'] == $table['zone_id']) {
                                        echo $zone['zone_name'];
                                    }
                                }
                                ?></td>
                            <td><?php echo $table['table_status'] == 0 ? 'ว่าง' : 'ไม่ว่าง'; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" name="delete_selected" class="btn btn-danger">ลบโต๊ะที่เลือก</button>
        </form>

        <!-- Delete All Tables in Selected Zone -->
        <?php if (!empty($selected_zone_id)) { ?>
            <form method="POST">
                <input type="hidden" name="zone_id" value="<?php echo $selected_zone_id; ?>">
                <button type="submit" name="delete_zone_tables" class="btn btn-danger mt-3">ลบโต๊ะทั้งหมดในโซนนี้</button>
            </form>
        <?php } ?>
    </div>
</body>

</html>
<script src="js/bootstrap.min.js"></script>