<?php
    session_start();
    require 'conn.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $pass_compile = date('Y-m-d',strtotime($password));
    $check_user = $conn->query("SELECT * FROM studen WHERE studen_key = '$username' AND studen_date = '$pass_compile'");
    if ($check_user->num_rows == 1) {
        foreach ($check_user as $row) {
            $student_id = $row['studen_id'];
        }
        $_SESSION['studen_id'] = $student_id;
?>
            <script>
                alert("Sussessfully");
                window.location.href = "user/user.php";
            </script>
<?php
    } else {
        $check_admin = $conn->query("SELECT * FROM admin WHERE admin_username = '$username' AND admin_password = '$password'");
        if ($check_admin->num_rows == 1) {
            foreach ($check_admin as $key) {
                $admin_id = $key['admin_id'];
            }
            $_SESSION['admin_id'] = $admin_id;
?>
            <script>
                alert("Sussessfully");
                window.location.href = "admin/admin.php";
            </script>
<?php
        } else {
?>
            <script>
                alert("กรุณาลองใหม่อีกครั้ง");
                window.location.href = "login.php";
            </script>
<?php            
        }
    }
?>