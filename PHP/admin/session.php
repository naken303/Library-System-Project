<?php
    session_start();
    if (isset($_GET['logout'])) {
        session_destroy();
?>
    <script>
        window.location.href = "../../index.php";
    </script>
<?php
    } else if (!isset($_SESSION['admin_id'])) {
?>
            <script>
                alert("กรุณาเข้าสู่ระบบ");
                window.location.href = "../login.php";
            </script>
<?php
    }
?>