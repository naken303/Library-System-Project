<?php
    require '../conn.php';
    require 'session.php';
    $total_have_book = $conn->query("SELECT * FROM num_book")->num_rows;
    $total_have_booking = $conn->query("SELECT * FROM num_book WHERE num_status = 1")->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../CSS/nav2.css">
    <link rel="stylesheet" href="../../CSS/a_book.css">
    <link rel="stylesheet" href="../../CSS/table_a.css">
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
                    <a href="admin.php"><li><i class="bi bi-house"></i> สถิติ</li></a>
                </ul>
                <ul class="secondary">
                    <h1>ข้อมูล</h1>
                    <a href="a_book.php"><li><i class="bi bi-journal-text"></i> รายการหนังสือ <p><?php echo $total_have_book?></p></li></a>
                    <a href="a_booking.php"><li><i class="bi bi-bookmark"></i> การยืม-คืน <p><?php echo $total_have_booking?></p></li></a>
                    <a href="a_member.php"><li class="hold"><i class="bi bi-person"></i> สมาชิก</li></a>
                    <a href="a_signin.php"><li><i class="fas fa-sign-in-alt"></i> การเข้าใช้</li></a>
                    <a href="card.php" target="_blank"><li><i class="fas fa-barcode"></i> Scan เข้าใช้ห้องสมุด</li></a>
                </ul>
                <ul class="login">
                    <a href="?logout"><li><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</li></a>
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
                </div>
            </div>
            <div class="outTable">
                <div class="shadow <?php if (isset($_GET['id']) || isset($_GET['del']) || isset($_GET['list']) || isset($_GET['memadd'])) {echo 'active';}?>" id="shadow" onclick="closeX()"></div>
                <div class="control">
                    <div class="edit" id="edit">
                        <form action="ps_member.php" method="post" enctype="multipart/form-data">
                            <div class="img" id="memba">
                                <img src="../IMG/" id="blah">
                                <input type="file" name="image" onchange="readURL(this);">
                            </div>
                            <div class="info">
                                <div class="form">
                                    <label for="">ชื่อนักเรียน</label>
                                    <input type="text" class="text" name="studenname" value="" required>
                                    <label for="">รหัสนักศึกษา</label>
                                    <input type="text" class="text" name="studenkey" value="" required>
                                    <label for="">ชั้นเรียน</label>
                                    <input type="text" class="text" name="studenclass" value="" required>
                                    <label for="">วันเดือนปีเกิด</label>
                                    <input type="date" class="text" name="studendate" value="" required>
                                    <div class="selt">
                                        <label>แผนก</label>
                                        <select name="department">
<?php
    $depa = $conn->query("SELECT * FROM department");
    foreach ($depa as $shoot) {
        $department_id = $shoot['department_id'];
        $department_name = $shoot['department_name'];
        echo "<option value='$department_id'>$department_name</option>";
    }
?>
                                        </select>
                                    </div>
                                    <button type="submit">ยืนยัน</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="jong" id="jong">
                    <form action="ps_booking.php" method="POST">
                        <div>
                            <label>id หนังสือ</label>
                            <input type="number" name="num_id" required>
                        </div>
                        <div>
                            <label>รหัสนักศึกษา</label>
                            <input type="number" name="student_key" required>
                        </div>
                        <div>
                            <label>วันที่ต้องคืน</label>
                            <input type="date" name="num_return" required>
                        </div>
                        <button type="submit">ยืมหนังสือ</button>
                    </form>
                </div>
                <div class="list <?php if (isset($_GET['list'])) { echo 'active';}?>" id="list">
                <div class="party" id="mem">
                    <div class="num-book">
<?php
    $lxc = $_GET['list'];
    $lbooking = $conn->query("SELECT * FROM num_book WHERE studen_id = $lxc AND num_status = 1");
    foreach ($lbooking as $evelynn) {
        $lNumid = $evelynn['barcode'];
        $lBookid = $evelynn['book_id'];
        $lbname = $conn->query("SELECT book_name FROM book WHERE book_id = $lBookid");
        foreach ($lbname as $leblanc) {
            $lbookname = $leblanc['book_name'];
        }
        echo "
            <div class='sum-b'>
                <h1>ID : $lNumid</h1>
                <h3>$lbookname</h3>
                <a href='ps_returnmain.php?retu=$lNumid&stukey=$lxc&pg' onclick='return confirm(`ต้องการจะคืน $lbookname ใช่หรือไม่`)'>คืน</a>
            </div>
        ";
    }
    if ($lbooking->num_rows < 1) {
        echo "<h1 style='color: #ffffff;'>ไม่มีรายการยืมหนังสือ</h1>";
    }
?>   
                        </div>
                    </div>
                </div>
                <button class="addMenu" onclick="openX()">เพิ่มสมาชิก</button>
                <table id="myTable">
                    <thead>
                        <tr>
                            <td>รหัสนักศึกษา</td>
                            <td>ชื่อนักศึกษา</td>
                            <td>แผนก</td>
                            <td>ชั้น</td>
                            <td>กำลังยืม</td>
                            <td>เคยยืมทั้งหมด</td>
                            <td></td>
                        </tr>
                    </thead>

                    <tbody>
<?php
    $ahh = $conn->query("SELECT * FROM studen");
    foreach ($ahh as $sett) {
        $studen_id = $sett['studen_id'];
        $studen_key = $sett['studen_key'];
        $studen_date = $sett['studen_date'];
        $studen_name = $sett['studen_name'];
        $department_id = $sett['department_id'];
        $studen_class = $sett['studen_class'];
        $studen_booked_total = $sett['studen_booked_total'];
        $rsD = $conn->query("SELECT department_name FROM department WHERE department_id = $department_id");
        foreach ($rsD as $dept) {
            $department_name = $dept['department_name'];
        }
        $rsNow = $conn->query("SELECT * FROM num_book WHERE num_status = 1 AND studen_id = $studen_id");
        $bookedNow = $rsNow->num_rows;
?>
                        <tr>
                            <td><?php echo $studen_key?></td>
                            <td><?php echo $studen_name?></td>
                            <td><?php echo $department_name?></td>
                            <td><?php echo $studen_class?></td>
                            <td><?php echo $bookedNow?></td>
                            <td><?php echo $studen_booked_total?></td>
                            <td>
                                <a href="?list=<?php echo $studen_id?>">คืนหนังสือ</a>
                            </td>
                        </tr>
<?php
    }    
?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script src="../../JS/jquery.js"></script>
    <script src="../../JS/table.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        let navBar = document.getElementById("nav");
        let conBox = document.getElementById("con");
        function openMenu() {
            navBar.classList.toggle("active");
            conBox.classList.toggle("active");
        }

        let shadow = document.getElementById("shadow");
        let jong = document.getElementById("jong");
        let edit = document.getElementById("edit");
        let list = document.getElementById("list");
        function openX() {
            shadow.classList.add("active");
            edit.classList.add("active");
        }

        function closeX() {
            shadow.classList.remove("active");
            jong.classList.remove("active");
            edit.classList.remove("active");
            list.classList.remove("active");
        }

        let plus = document.getElementById("plus");
        function plusNum() {
            plus.classList.toggle("active");
        } 
    </script>
</body>
</html>