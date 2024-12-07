<?php
    require '../conn.php';
    require 'session.php';
    $num_id = $_GET['bruh'];
    $del = $conn->query("DELETE FROM num_book WHERE barcode = '$num_id'");
    if ($del) {
?>
        <script>
            alert("ลบสำเร็จ");
            location.href="a_book.php";
        </script>
<?php
        } else {
?>
        <script>
            alert("ลบล้มเหลม");
            location.href="a_book.php";
        </script>
<?php            
    }
?>