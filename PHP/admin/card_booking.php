<?php
    date_default_timezone_set('Asia/Bangkok');
    $dateday = date('Y-m-d');
    $datetime = date('H:i:s');
    require '../conn.php';
    require 'session.php';
    if (isset($_POST['student']) && isset($_POST['book']) && isset($_POST['date'])) {
        $student = $_POST['student'];
        $book = $_POST['book'];
        $date_return = $_POST['date'];
        $check_std = $conn->query("SELECT studen_id , department_id FROM studen WHERE studen_key = $student");
        if ($check_std->num_rows > 0) {
            foreach ($check_std as $row) {
                $studen_id = $row['studen_id'];
                $department_id = $row['department_id'];
            }
            $check_num = $conn->query("SELECT * FROM num_book WHERE num_id = $book");
            if ($check_num->num_rows > 0) {
                $rs = $conn->query("UPDATE num_book SET num_status = 1 , studen_id = $studen_id , num_booking = '$dateday' , num_return = '$date_return' , department_id = $department_id WHERE num_id = $book");
                if ($rs) {
?>
                <script>
                    alert("ยืมสำเร็จ");
                </script>
<?php
                } else {
?>
                <script>
                    alert("ยืมล้มเหลว");
                </script>
<?php                    
                }
            }
        } else {
?>
        <script>
            alert("ไม่มีนักเรียนในฐานข้อมูล");
            location.href="card_booking.php";
        </script>
<?php
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libary | barcode scan</title>
</head>
<body>
    <form action="card_booking.php" method="post">
        <label>บาร์โค้ดรหัสนักเรียน</label>
        <input type="text" name="student" id="student" onchange="focusBookInput(1)" autofocus required>
        <label>บาร์โค้ดหนังสือ</label>
        <input type="text" name="book" id="book" onchange="focusBookInput(2)" required>
        <label>เลือกวันที่ต้องคืน</label>
        <input type="date" name="date" required>
        <button type="submit">ยืนยัน</button>
    </form>
    <script>
        let stu = document.getElementById("student");
        let book = document.getElementById("book");
        function focusBookInput(n) {
            if (n = 1) {
                book.focus();
            } else if (n = 2) {
                stu.focus();
            }
        }
    </script>
</body>
</html>