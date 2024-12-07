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
                    <a href="a_booking.php"><li><i class="bi bi-bookmark"></i> การยืม-คืน <p><?php echo $total_have_booking?></p></li></a>
                    <a href="a_member.php"><li><i class="bi bi-person"></i> สมาชิก</li></a>
                    <a href="a_signin.php"><li class="hold"><i class="fas fa-sign-in-alt"></i> การเข้าใช้</li></a>
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
            <div class="shadow <?php if (isset($_GET['id']) || isset($_GET['del']) || isset($_GET['deid']) || isset($_GET['list']) || isset($_GET['cata']) || isset($_GET['shitY'])) {echo 'active';}?>" id="shadow" onclick="closeX()"></div>
            <div class="btn-box">
                <button class="addMenu" onclick="openY()">ดูเฉพาะแผนก</button>
                <button class="addMenu" onclick="openX()">ยอดแต่ละเดือน</button>
                <?php
                    if (isset($_GET['onlytoday'])) {
                        echo "<a href='a_signin.php' class='addMenu'>แสดงทั้งหมด</a>";
                    } else {
                        echo "<a href='?onlytoday' class='addMenu'>แสดงเฉพาะวันนี้</a>";
                    }
                ?>
                <form method='post' class='fastform' action='a_signin.php'>
                    <div class='ins'>
                        <label>วันเริ่ม</label>
                        <input type='date' name='asdwstart'>
                    </div>
                    <div class='ins'>
                        <label>วันสิ้นสุด</label>
                        <input type='date' name='asdwend'>
                    </div>
                    <button type='submit'>ยืนยัน </button>
                </form>
            </div>
                <div class="new <?php if (isset($_GET['shitY'])) {echo "active";}?>" id="jong">
                    <div class="shit">
                        <div class="shit-l">
                            <h4>การเข้าใช้แยกเป็นเดือน</h4>
<?php
    $wow = $conn->query("SELECT DISTINCT MONTH(record_date) AS 'Month' , YEAR(record_date) AS 'Year' FROM record ORDER BY record_date DESC");
    foreach ($wow as $yoyo) {
        $month = $yoyo['Month'];
        $year = $yoyo['Year'];
        $manny = $conn->query("SELECT * FROM record WHERE MONTH(record_date) = $month AND YEAR(record_date) = $year")->num_rows;
        echo "
        <a href='?shitY=$year&shitM=$month&memmy=$manny'>
            <div class='f-shit-l'>
                <div class='f-l'>$month/$year</div>
                <div class='f-r'>$manny</div>
            </div>
        </a>
        ";
        
    }
?>
                        </div>
                        <div class="shit-r">
                            
                                   
                                
                            <?php
                                if (isset($_GET['shitY']) && isset($_GET['shitM'])) {
                                    $shitY = $_GET['shitY'];
                                    $shitM = $_GET['shitM'];
                                    $memmy = $_GET['memmy'];
                                    $noos = 0;
                                    $hasbeen = $conn->query("SELECT * FROM record WHERE MONTH(record_date) = $shitM AND YEAR(record_date) = $shitY");
                                    echo "
                                    <div class='f-shit-l'>
                                        <div class='f-l'>$shitM/$shitY</div>
                                        <div class='f-r'>$memmy</div>
                                    </div>
                                    <div class='warp-table'>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td>ลำดับ</td>
                                                    <td>รหัสนักเรียน</td>
                                                    <td>ชื่อ-นามสกุล</td>
                                                    <td>วันที่เข้า</td>
                                                    <td>เวลาที่เข้า</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    ";
                                    foreach ($hasbeen as $kaous) {
                                        $noos++;
                                        $lum = $kaous['record_id'];
                                        $ltime = $kaous['record_time'];
                                        $ldate = $kaous['record_date'];
                                        $lstid = $kaous['studen_id'];
                                        $sasd = $conn->query("SELECT studen_key,studen_name FROM studen WHERE studen_id = $lstid");
                                        foreach ($sasd as $sdg) {
                                            $lstkey = $sdg['studen_key'];
                                            $lstname = $sdg['studen_name'];
                                        }
                                        echo "
                                            <tr>
                                                <td>$noos</td>
                                                <td>$lstkey</td>
                                                <td>$lstname</td>
                                                <td>".date('d/m/Y',strtotime($ldate))."</td>
                                                <td>$ltime</td>
                                            </tr>
                                        ";
                                    }
                                    echo "
                                            </tbody>
                                        </table>
                                    </div>
                                    ";
                                } else {
                                    echo "<p style='color: #ffffff; font-size: 22px;'>เลือกข้อมูลที่ต้องการดู</p>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="new <?php if (isset($_GET['deid'])) {echo "active";}?>" id="jai">
                    <div class="shit">
                        <div class="shit-l sec">
                            <h4>การเข้าใช้แยกเป็นแผนก</h4>
<?php
    $wow = $conn->query("SELECT DISTINCT department_id FROM record");
    foreach ($wow as $yoyo) {
        $department_id = $yoyo['department_id'];
        $depaname = $conn->query("SELECT department_name FROM department WHERE department_id = $department_id");
        foreach ($depaname as $dop) {
            $department_name = $dop["department_name"];
        }
        $manny = $conn->query("SELECT * FROM record WHERE department_id = $department_id")->num_rows;
        $das = $conn->query("SELECT * FROM record WHERE department_id = $department_id");
        foreach ($das as $skad) {
            // $department_name = $skad["department_name"];
        }
        echo "
        <a href='?deid=$department_id'>
            <div class='f-shit-l'>
                <div class='f-l'>$department_name</div>
                <div class='f-r'>$manny</div>
            </div>
        </a>
        ";
        
    }
?>
                        </div>
                        <div class="shit-r">
                            <?php
                                if (isset($_GET['deid'])) {
                                    $deid = $_GET['deid'];
                                    $depanames = $conn->query("SELECT department_name FROM department WHERE department_id = $department_id");
                                    foreach ($depanames as $dop) {
                                        $department_names = $dop["department_name"];
                                    }
                                    $noos = 0;
                                    if (isset($_POST['datedstart']) && isset($_POST['datedend'])) {
                                        $datedstart = $_POST['datedstart'];
                                        $datedend = $_POST['datedend'];
                                        $hasbeenmany = $conn->query("SELECT * FROM record WHERE department_id = $deid AND record_date BETWEEN '$datedstart' AND '$datedend'")->num_rows;
                                        $hasbeendep = $conn->query("SELECT * FROM record WHERE department_id = $deid AND record_date BETWEEN '$datedstart' AND '$datedend' ORDER BY record_date DESC");
                                    } else {
                                        $hasbeenmany = $conn->query("SELECT * FROM record WHERE department_id = $deid ")->num_rows;
                                        $hasbeendep = $conn->query("SELECT * FROM record WHERE department_id = $deid ORDER BY record_date DESC");
                                    }
                                    
                                    echo "
                                    <div class='sd' style='display: flex;'>
                                        <div class='f-shit-l'>
                                            <div class='f-l' style='width: 200px;'>$department_names</div>
                                            <div class='f-r'>$hasbeenmany</div>
                                        </div>
                                        <div class='f-shit-l'>
                                            <form method='post' action='?deid=$deid' style='display: flex; padding-left: 1em;'>
                                                <div class='ins'>
                                                    <label style='color: #ffffff;'>วันเริ่ม</label>
                                                    <input type='date' name='datedstart' style=''>
                                                </div>
                                                <div class='ins'>
                                                    <label style='color: #ffffff;'>วันสิ้นสุด</label>
                                                    <input type='date' name='datedend' style=''>
                                                </div>
                                                <button style='height: 40px; margin: 10px;' type='submit'>ยืนยัน</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class='warp-table'>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td>ลำดับ</td>
                                                    <td>รหัสนักเรียน</td>
                                                    <td>ชื่อ-นามสกุล</td>
                                                    <td>วันที่เข้า</td>
                                                    <td>เวลาที่เข้า</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    ";
                                    foreach ($hasbeendep as $kaous) {
                                        $noos++;
                                        $lum = $kaous['record_id'];
                                        $ltime = $kaous['record_time'];
                                        $ldate = $kaous['record_date'];
                                        $lstid = $kaous['studen_id'];
                                        $sasd = $conn->query("SELECT studen_key,studen_name FROM studen WHERE studen_id = $lstid");
                                        foreach ($sasd as $sdg) {
                                            $lstkey = $sdg['studen_key'];
                                            $lstname = $sdg['studen_name'];
                                        }
                                        echo "
                                            <tr>
                                                <td>$noos</td>
                                                <td>$lstkey</td>
                                                <td>$lstname</td>
                                                <td>".date('d/m/Y',strtotime($ldate))."</td>
                                                <td>$ltime</td>
                                            </tr>
                                        ";
                                    }
                                    echo "
                                            </tbody>
                                        </table>
                                    </div>
                                    ";
                                } else {
                                    echo "<p style='color: #ffffff; font-size: 22px;'>เลือกข้อมูลที่ต้องการดู</p>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <table id="myTable">
                    <thead>
                        <tr>
                            <td>ลำดับ</td>
                            <td>รหัสนักเรียน</td>
                            <td>ชื่อนักเรียน</td>
                            <td>ชั้น</td>
                            <td>แผนก</td>
                            <td>วันที่เข้า</td>
                            <td>เวลาที่เข้า</td>
                        </tr>
                    </thead>

                    <tbody>
<?php
    if (isset($_GET['onlytoday'])) {
        $ahh = $conn->query("SELECT * FROM record WHERE record_date = '$current_date'");
        $no = 0;
    } else if (isset($_POST["asdwstart"]) && isset($_POST["asdwend"])) {
        $asdwstart = $_POST["asdwstart"];
        $asdwend = $_POST["asdwend"];
        $ahh = $conn->query("SELECT * FROM record WHERE record_date BETWEEN '$asdwstart' AND '$asdwend' ORDER BY record_date");
        $no = 0;
    } else {
        $ahh = $conn->query("SELECT * FROM record");
        $no = 0;
    }
    foreach ($ahh as $sion) {
        $rec_id = $sion['record_id'];
        $st_id = $sion['studen_id'];
        $record_date = $sion['record_date'];
        $record_time = $sion['record_time'];
        $ass = $conn->query("SELECT * FROM studen WHERE studen_id = $st_id");
        foreach ($ass as $fiora) {
            $st_name = $fiora['studen_name'];
            $st_key = $fiora['studen_key'];
            $st_class = $fiora['studen_class'];
            $st_depart = $fiora['department_id'];
            $dss = $conn->query("SELECT department_name FROM department WHERE department_id = $st_depart");
            foreach ($dss as $zac) {
                $depart_name = $zac['department_name'];
                $no++;
            
?>
                        <tr>
                            <td><?php echo $no;?></td>
                            <td><?php echo $st_key;?></td>
                            <td><?php echo $st_name;?></td>
                            <td><?php echo $st_class;?></td>
                            <td><?php echo $depart_name;?></td>
                            <td><?php echo date('d/m/Y',strtotime($record_date));?></td>
                            <td><?php echo $record_time;?></td>
                        </tr>
<?php
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
        let jai = document.getElementById("jai");
        function openX() {
            shadow.classList.add("active");
            jong.classList.add("active");
        }

        function closeX() {
            shadow.classList.remove("active");
            jong.classList.remove("active");
            jai.classList.remove("active");
        }

        function openY() {
            shadow.classList.add("active");
            jai.classList.add("active");
        }

        let plus = document.getElementById("plus");
        function plusNum() {
            plus.classList.toggle("active");
        } 
    </script>
</body>
</html>