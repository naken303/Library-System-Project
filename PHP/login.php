<?php
    require 'conn.php';
    header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/reset.css">
    <link rel="stylesheet" href="../CSS/nav2.css">
    <link rel="stylesheet" href="../CSS/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
    <section>
    <nav class="" id="nav">
            <div class="s-menu">
                <button onclick="openMenu()"><i class="fas fa-bars"></i></button>
            </div>
            <div class="menu">
                <ul class="main">
                    <h1>เมนู</h1>
                    <a href="../index.php"><li><i class="bi bi-house"></i> หน้าแรก</li></a>
                    <a href="user/user.php"><li><i class="bi bi-person"></i> บัญชีผู้ใช้</li></a>
                </ul>
                <ul class="login">
                    <a href="login.php"><li class="hold"><i class="bi bi-person"></i> เข้าสู่ระบบ</li></a>
                </ul>
            </div>
        </nav>
        <div class="con" id="con">
            <div class="topbar">
                <div class="btn-menu">
                    <button onclick="openMenu()"><i class="fas fa-bars"></i></button>
                </div>
                <div class="name">
                    <h1>Suratthani Vocational Collage Library</h1>
                    <img src="../IMG/22243_16061313133855.png" alt="">
                </div>
            </div>
            <div class="main-content">
            <div class="box-log">
                <h1>Library Digital</h1>
                <h2>sign in you personal account</h2>
                <div class="login-f">
                    <div class="top-l">
                        <img src="../IMG/22243_16061313133855.png" alt="">
                        <div class="text-t-l">
                            <h3>วิทยาลัยอาชีวศึกษาสุราษฎร์ธานี</h3>
                            <h4>ห้องสมุด</h4>
                        </div>
                    </div>
                    <form action="ps_login.php" method="post">
                        <input type="text" class="lo" name="username" placeholder="username">
                        <input type="password" class="lo" name="password" placeholder="password">
                        <button type="submit">เข้าสู่ระบบ</button>
                    </form>
                    <div class="explain">
                        <h4>ผู้ใช้งาน</h4>
                        <p>ให้ใส่รหัสผ่านนักศึกษา ตัวอย่าง 62202040069</p>
                        <h4>รหัสผ่าน</h4>
                        <p>ใส่วันเดือนปีเกิด ตัวอย่าง<br>
                            - 23-09-2001<br>
                            - 09-09-1998</p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
    <script src="../JS/jquery.js"></script>
    <script>
        function openMenu() {
            let navBar = document.getElementById("nav");
            let conBox = document.getElementById("con");
            navBar.classList.toggle("active");
            conBox.classList.toggle("active");
        }
    </script>
</body>
</html>