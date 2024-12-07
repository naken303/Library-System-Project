<?php
    require '../conn.php';
    require 'session.php';
    date_default_timezone_set('Asia/Bangkok');
    $current_date = date('Y-m-d');
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
                    <a href="a_booking.php"><li class="hold"><i class="bi bi-bookmark"></i> การยืม-คืน <p><?php echo $total_have_booking?></p></li></a>
                    <a href="a_member.php"><li><i class="bi bi-person"></i> สมาชิก</li></a>
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
                <div class="shadow <?php if (isset($_GET['id']) || isset($_GET['del']) || isset($_GET['list'])) {echo 'active';}?>" id="shadow" onclick="closeX()"></div>
                <div class="jong" id="jong">
                    <form action="ps_booking.php" method="POST">
                        <div>
                            <label>id หนังสือ</label>
                            <input type="text" name="num_id" id="num_id" required onchange="focusBookInput()">
                        </div>
                        <div>
                            <label>รหัสนักศึกษา</label>
                            <input type="number" name="studen_key" required id="number">
                        </div>
                        <div>
                            <label>วันที่ต้องคืน</label>
                            <input type="date" name="num_return" required>
                        </div>
                        <button type="submit">ยืมหนังสือ</button>
                    </form>
                </div>
                <button class="addMenu" onclick="openX()">ยืมหนังสือ</button>
                <table id="myTable">
                    <thead>
                        <tr>
                            <td>เลขทะเบียน</td>
                            <td>ชื่อหนังสือ</td>
                            <td>รหัสนักศึกษา</td>
                            <td>ชื่อนักเรียน</td>                            
                            <td>แผนก</td>
                            <td>วันที่ยืม</td>
                            <td>วันที่ต้องคืน</td>
                            <td></td>
                        </tr>
                    </thead>

                    <tbody>
<?php
    $ahh = $conn->query("SELECT * FROM num_book WHERE num_status = 1");
    foreach ($ahh as $yi) {
        $zNumid = $yi['num_id'];
        $barcode = $yi['barcode'];
        $zBookid = $yi['book_id'];
        $zStatus = $yi['num_status'];
        $zStudenid = $yi['studen_id'];
        $zDatebooking = $yi['num_booking'];
        $zDatereturn = $yi['num_return'];
        $bookShow = $conn->query("SELECT book_name FROM book WHERE book_id = $zBookid");
        $studentShow = $conn->query("SELECT * FROM studen WHERE studen_id = $zStudenid");
        foreach ($bookShow as $ahri) {
            $zBookname = $ahri['book_name'];
            foreach ($studentShow as $ahri) {
                $zStudentname = $ahri['studen_name'];
                $zKey = $ahri['studen_key'];
                $zClass = $ahri['studen_class'];
                $zDepartid = $ahri['department_id'];
                $depart = $conn->query("SELECT department_name FROM department WHERE department_id = $zDepartid");
                foreach ($depart as $yummi) {
                    $zDepartment = $yummi['department_name'];
?>
                        <tr>
                            <td><?php echo $barcode;?></td>
                            <td><?php echo $zBookname;?></td>
                            <td><?php echo $zKey;?></td>
                            <td><?php echo $zStudentname;?></td>
                            <td><?php echo $zDepartment;?></td>
                            <td><?php echo date('d/m/Y',strtotime($zDatebooking));?></td>
                            <td <?php if ($current_date > $zDatereturn) {echo "style='color: #ff4b4b;'";}?>><?php echo date('d/m/Y',strtotime($zDatereturn));?></td>
                            <td>
                                <a href="ps_returnmain.php?retu=<?php echo $zNumid;?>&stukey=<?php echo $zStudenid?>">คืนหนังสือ</a>
                            </td>
                        </tr>
<?php
                }
            }
        }
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

        let navBar = document.getElementById("nav");
        let conBox = document.getElementById("con");
        function openMenu() {
            navBar.classList.toggle("active");
            conBox.classList.toggle("active");
        }

        let shadow = document.getElementById("shadow");
        let jong = document.getElementById("jong");
        let num_id = document.getElementById("num_id");
        function openX() {
            shadow.classList.add("active");
            jong.classList.add("active");
            num_id.focus();
        }

        function closeX() {
            shadow.classList.remove("active");
            jong.classList.remove("active");
        }

        let plus = document.getElementById("plus");
        function plusNum() {
            plus.classList.toggle("active");
        } 
        function focusBookInput(n) {
            let number = document.getElementById("number");
            
            number.focus();
        }
    </script>
</body>
</html>