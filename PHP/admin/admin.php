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
    <link rel="stylesheet" href="../../CSS/admin.css">
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
                    <a href="admin.php"><li class="hold"><i class="bi bi-house"></i> สถิติ</li></a>
                </ul>
                <ul class="secondary">
                    <h1>ข้อมูล</h1>
                    <a href="a_book.php"><li><i class="bi bi-journal-text"></i> รายการหนังสือ <p><?php echo $total_have_book?></p></li></a>
                    <a href="a_booking.php"><li><i class="bi bi-bookmark"></i> การยืม-คืน <p><?php echo $total_have_booking?></p></li></a>
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
            <div class="outBox">
                <div class="shadow">
                    
                </div>
                <div class="dataBox">
                    <div class="topData">
                        <div class="fourthBox">
<?php
    $signInToday = $conn->query("SELECT * FROM record WHERE record_date = '$current_date'")->num_rows;
    $sum_rc = "SELECT SUM(studen_booked_total) as sum_paid FROM studen";
    $query_sum = $conn->query($sum_rc);
    $result = mysqli_fetch_array($query_sum);
?>
                            <p>เข้าใช้งาน/วันนี้</p>
                            <h1><?php echo $signInToday;?> คน</h1>
                        </div>
                        <div class="fourthBox">
                            <p>หนังสือทั้งหมด</p>
                            <h1><?php echo $total_have_book;?> เล่ม</h1>
                        </div>
                        <div class="fourthBox">
                            <p>กำลังยืมทั้งหมด</p>
                            <h1><?php echo $total_have_booking;?> เล่ม</h1> 
                        </div>
                        <div class="fourthBox">
                            <p>ยืมสะสม</p>
                            <h1><?php echo $result["sum_paid"]; ?> ครั้ง</h1>
                        </div>
                    </div>
                    <div class="mydata">
                        <h4 style="margin-bottom: 1em;">สถิติของแผนก</h4>
                        <table id="myTable">
                            <thead>
                                <tr>
                                    <td>แผนก</td>
                                    <td>การเข้าใช้ห้องสมุด</td>
                                    <td>ยืมหนังสือสะสม</td>
                                    <td>กำลังยืมอยู่</td>
                                </tr>
                            </thead>
                            <tbody>
<?php
    $depart_num = $conn->query("SELECT * FROM department");
    foreach ($depart_num as $nova) {
        $dep_id = $nova['department_id'];
        $dep_name = $nova['department_name'];
        $record = $conn->query("SELECT * FROM record WHERE department_id = $dep_id")->num_rows;
        $sum_booked = "SELECT SUM(studen_booked_total) as sum_booking FROM studen WHERE department_id = $dep_id";
        $query_sum = $conn->query($sum_booked);
        $rs_booked = mysqli_fetch_array($query_sum);
        $tot_booked = $rs_booked["sum_booking"];
        $num_booking = $conn->query("SELECT * FROM num_book WHERE department_id = $dep_id")->num_rows;
        echo "<tr>
                <td id='depart'>$dep_name</td>
                <td>$record</td>
                <td>$tot_booked</td>
                <td>$num_booking</td>
            </tr>
        ";
    } 
?>
                                
                                    
                                    
                                
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <script src="../../JS/jquery.js"></script>
    <script src="../../JS/table.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
        function openMenu() {
            let navBar = document.getElementById("nav");
            let conBox = document.getElementById("con");
            navBar.classList.toggle("active");
            conBox.classList.toggle("active");
        }
    </script>
</body>
</html>