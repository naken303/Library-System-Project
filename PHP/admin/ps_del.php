<?php
    require '../conn.php';
    require 'session.php';
    $bookid = $_POST['dell'];
    $cks = $conn->query("SELECT * FROM num_book WHERE book_id = $bookid AND num_status = 1")->num_rows;
    if ($cks > 0) {
?>
    <script>
        alert("ยังมีนักเรียนยืมหนังสืออยู่");
        location.href="a_book.php";
    </script>
<?php
    }
    $se_pic = $conn->query("SELECT book_picture FROM book WHERE book_id = $bookid");
    foreach ($se_pic as $row) {
        $pic = $row['book_picture'];
    }
    $del_pic = unlink("../../IMG/$pic");
    if ($del_pic) {
        $del_num = $conn->query("DELETE FROM num_book WHERE book_id = $bookid");
        if ($del_num) {
            $del_book = $conn->query("DELETE FROM book WHERE book_id = $bookid");
            if ($del_book) {
?>                
<script>
                alert("ลบสำเร็จ");
                location.href="a_book.php";
</script>   
<?php
            } else {
?>
<script>
                alert("ลบหนังสือไม่สำเร็จ");
                location.href="a_book.php";
</script>
<?php
            }
        } else {
?>
<script>
            alert("ลบจำนวนไม่สำเร็จ");
            location.href="a_book.php";
</script>
<?php
        }
    } else {
?>
<script>
        alert("ลบรูปไม่สำเร็จ");
        location.href="a_book.php";
</script>
<?php
    }
?>