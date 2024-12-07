<?php
    date_default_timezone_set('Asia/Bangkok');
    require '../conn.php';
    require 'session.php';
    $num_id = $_POST['num_id'];
    $book = $conn->query("SELECT book_id FROM num_book WHERE barcode = '$num_id'");
    foreach ($book as $aatrox) {
        $book_id = $aatrox['book_id'];
    }
    $studen_key = $_POST['studen_key'];
    $num_return = $_POST['num_return'];
    $studen_confirm = $conn->query("SELECT studen_id , department_id FROM studen WHERE studen_key = $studen_key");
    if ($studen_confirm->num_rows != 1) {
?>
    <script>
        alert("นักเรียนมีปัญหา");
        location.href="a_booking.php"
    </script>
<?php
    } else {
        foreach ($studen_confirm as $yasuo) {
            $studen_id = $yasuo['studen_id'];
            $department_id = $yasuo['department_id'];
        }
        $date_now = date('Y-m-d');
        $rs = $conn->query("UPDATE num_book SET studen_id = '$studen_id' , num_booking = '$date_now' ,num_return = '$num_return' , num_status = 1 , department_id = $department_id WHERE barcode = '$num_id'");
        $total = $conn->query("SELECT book_booked_total FROM book WHERE book_id = $book_id");
        foreach ($total as $fuk) {
            $dippy = $fuk['book_booked_total'];
        }
        $snowy = $dippy+1;
        $booked_total = $conn->query("UPDATE book SET book_booked_total = $snowy WHERE book_id = $book_id");

        $muscle = $conn->query("SELECT studen_booked_total FROM studen WHERE studen_id = $studen_id");
        foreach ($muscle as $fool) {
            $lucky = $fool['studen_booked_total'];
        }   
        $rainy = $lucky+1;
        $studen_total = $conn->query("UPDATE studen SET studen_booked_total = $rainy WHERE studen_id = $studen_id");
        if ($rs && $studen_total && $booked_total) {
?>
        <script>
            alert("ยืมสำเร็จ");
            location.href="a_booking.php";
        </script>
<?php
        } else {
?>
        <script>
            alert("ยืมล้มเหลม");
        </script>
<?php            
        }
    }
?>
