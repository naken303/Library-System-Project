<?php
    require '../conn.php';
    require 'session.php';
    $num_id = $_GET['retu'];
    $studen_id = $_GET['stukey'];

    $rs = $conn->query("UPDATE num_book SET studen_id = 0 , num_return = 0 , num_booking = 0 , num_status = 0 , department_id = 0 WHERE num_id = $num_id and studen_id = $studen_id");
    if ($rs && !isset($_GET['pg'])) {
?>
        <script>
            alert("คืนสำเร็จ");
            window.location.href="a_booking.php";
        </script>
<?php           
    } else if ($rs && isset($_GET['pg'])) {
?>
        <script>
            
        </script>
<?php
        header("location:a_member.php?list=$studen_id");
        alert("คืนสำเร็จ");
        
    } else {
?>
        <script>
            alert("error");
        </script>
<?php          
    }
?>