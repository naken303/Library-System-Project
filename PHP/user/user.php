<?php
    require '../conn.php';
    require 'session.php';
    $studen_id = $_SESSION['studen_id'];
    $studen = $conn->query("SELECT * FROM studen WHERE studen_id = $studen_id");
    foreach ($studen as $bad) {
        $studen_key = $bad['studen_key'];
        $studen_name = $bad['studen_name'];
        $department_id = $bad['department_id'];
        $studen_class = $bad['studen_class'];
        $studen_booked_total = $bad['studen_booked_total'];
        $department = $conn->query("SELECT department_name FROM department WHERE department_id = $department_id");
        foreach ($department as $depart) {
            $department_name = $depart['department_name'];
        }
    }
    $record_total = $conn->query("SELECT * FROM record WHERE studen_id = $studen_id")->num_rows;
    $record = $conn->query("SELECT * FROM record WHERE studen_id = $studen_id ORDER BY record_id DESC LIMIT 10 ");

    $booking = $conn->query("SELECT * FROM num_book WHERE studen_id = $studen_id AND num_status = 1");
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libary | <?php echo $studen_name?></title>
    <!-- <link rel="stylesheet" href="../../CSS/nav2.css"> -->
    <link rel="stylesheet" href="../../SCSS/reset.css">
    <link rel="stylesheet" href="../../SCSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../../CSS/user.css">
    <link rel="stylesheet" href="../../CSS/table.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
    <section>
        <nav class="pk-1" id="nav">
            <div class="menu">
                <ul class="main">
                    <h1>เมนู</h1>
                    <a href="index.php"><li><i class="bi bi-house"></i> <p>หน้าแรก</p></li></a>
                    <a href="user.php"><li class="hold"><i class="bi bi-person"></i> <p>บัญชีผู้ใช้</p></li></a>
                    <a href="?logout"><li><i class="fas fa-sign-out-alt"></i> <p>ออกจากระบบ</p></li></a>
                </ul>
                <ul class="secondary">
                    <h1>สถิติ</h1>
                    <a href="#"><li><i class="bi bi-journal-text"></i> <p>เข้าใช้ห้องสมุด</p> <p><?php echo $record_total?></p></li></a>
                    <a href="#"><li><i class="bi bi-bookmark"></i> <p>กำลังยืมอยู่</p> <p><?php echo $booking->num_rows?></p></li></a>
                    <a href="#"><li><i class="bi bi-bookmark"></i> <p>เคยยืมทั้งหมด</p> <p><?php echo $studen_booked_total?></p></li></a>
                </ul>
                <ul class="login">
                    
                </ul>
            </div>
        </nav>
        <div class="con" id="con">
            <div class="topbar pk-1">
                <form class="search" action="index.php" method="post">
                    <input type="text" name="search" placeholder="ค้นหาหนังสือ">
                    <button type="submit"></button>
                </form>
                <div class="name">
                    <h1>ห้องสมุดวิทยาลัยอาชีวะศึกษาสุราษฎร์ธานี</h1>
                    <img src="../../IMG/22243_16061313133855.png" alt="">
                </div>
            </div>
            <div class="main-content">
            <div class="user">
                <div class="f-his">
                    <div class="warp">
                        <div class="profile">
                            <div class="top-p">
                                <img src="../../IMG/studen/<?php echo $studen_key?>.JPG" alt="">
                                <div class="name-p">
                                    <h1><?php echo $studen_name;?></h1>
                                    <h2><?php echo $department_name;?></h2>
                                    <h3><?php echo $studen_key;?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="check-in">
                            <div class="text-ch">
                                <h5>เวลาการเข้าใช้ห้องสมุด</h5>
                                <h5><?php echo $record_total?> ครั้ง</h5>
                            </div>
                            <ul>
<?php
    if ($record->num_rows > 0) {
        foreach ($record as $mok) {
            $record_date = $mok['record_date'];
            $record_time = $mok['record_time'];
                echo "<li><h6>$record_time น.</h6><h6>".date('d/m/Y', strtotime($record_date))."</h6></li>";
        }
    } else {
        echo "<li><h6>ไม่มีข้อมูล</h6></li>";
    }
?>
                            </ul>
                        </div>
                    </div>
                    <div class="booking">
                        <h3 style="color: #ffffff;">รายการยืม <?php echo "$booking->num_rows"?> เล่ม</h3>
                        <table id="myTable">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>ชื่อหนังสือ</td>
                                    <td>วันที่ยืม</td>
                                    <td>วันที่ต้องคืน</td>
                                </tr>
                            </thead>
                            <tbody>
<?php
    foreach ($booking as $minion) {
        $num_id = $minion['num_id'];
        $barcode = $minion['barcode'];
        $num_booking = $minion['num_booking'];
        $num_return = $minion['num_return'];
        $book_id = $minion['book_id'];
        $bookrs = $conn->query("SELECT book_name FROM book WHERE book_id = $book_id");
        foreach ($bookrs as $baron) {
            $book_name = $baron['book_name'];
            echo "
                <tr>
                    <td>$barcode</td>
                    <td>$book_name</td>
                    <td>".date('d/m/Y', strtotime($num_booking))."</td>
                    <td>".date('d/m/Y', strtotime($num_return))."</td>
                </tr>
            ";
        }
    }
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
    <script src="../../JS/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        function openMenu() {
            let navBar = document.getElementById("nav");
            let conBox = document.getElementById("con");
            navBar.classList.toggle("active");
            conBox.classList.toggle("active");
        }
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
</body>
</html>