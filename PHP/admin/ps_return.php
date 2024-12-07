<?php
    require '../conn.php';
    require 'session.php';
    $num_id = $_GET['retu'];
    $studen_id = $_GET['stukey'];

    $rs = $conn->query("UPDATE num_book SET studen_id = 0 , num_return = 0 , num_booking = 0 , num_status = 0 , department_id = 0 WHERE num_id = $num_id and studen_id = $studen_id");
    if ($rs) {
?>
        <script>
            alert("คืนสำเร็จ");
            location.href="a_book.php";
        </script>
<?php
        } else {
?>
        <script>
            alert("คืนล้มเหลม");
            location.href="a_book.php";
        </script>
<?php            
    }
?>