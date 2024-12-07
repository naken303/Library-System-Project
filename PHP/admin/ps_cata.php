<?php
    require '../conn.php';
    require 'session.php';
    if (isset($_GET['catadd'])) {
        $cata_add = $_POST['addcata'];
        $rs = $conn->query("INSERT INTO catagory (catagory_id,catagory_name) VALUE ('','$cata_add')");
        if ($rs) {
?>
        <script>
            alert("เพิ่มสำเร็จ");
            location.href="a_book.php?cata";
        </script>
<?php
        } else {
?>
        <script>
            alert("เพิ่มล้มเหลว");
            location.href="a_book.php?cata";
        </script>
<?php            
        }
    } else if (isset($_GET['catadel'])) {
        $cata_del = $_POST['delcata'];
        $rs = $conn->query("DELETE FROM catagory WHERE catagory_id = $cata_del");
        if ($rs) {
?>
        <script>
            alert("ลบสำเร็จ");
            location.href="a_book.php?cata";
        </script>
<?php
        } else {
?>
        <script>
            alert("ลบล้มเหลว");
            location.href="a_book.php?cata";
        </script>
<?php            
        }
    } else {
?>
        <script>
            alert("error");
        </script>
<?php
    }
?>