<?php
    require '../conn.php';
    require 'session.php';
    $num = $_POST['plus_num'];
    $book_plus = $_POST['plus_name'];
    for ($i = 0; $i < $num; $i++) { 
        $plusNum = $conn->query("INSERT INTO num_book (num_id , book_id , num_status , studen_id) VALUE ('','$book_plus','0','0')");
    }
?>
    <script>
        alert("เพิ่มสำเร็จ");
        location.href="a_book.php";
    </script>