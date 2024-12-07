<?php
    require 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../SCSS/style.css">
    <link rel="stylesheet" href="../CSS/slide2.css">
    <link rel="stylesheet" href="../CSS/info.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
    <nav class="pk-1" id="nav">
            <div class="menu">
                <ul class="main">
                    <h1>เมนู</h1>
                    <a href="../index.php"><li class="hold"><i class="bi bi-house"></i> <p>หน้าแรก</p></li></a>
                    <a href="login.php"><li><i class="bi bi-person"></i> <p>เข้าสู่ระบบ</p></li></a>
                </ul>
                <ul class="login"></ul>
            </div>
        </nav>
        <div class="con" id="con">
            <div class="topbar pk-1">
                <form class="search" action="../index.php" method="post">
                    <input type="text" name="search" placeholder="ค้นหาหนังสือ">
                    <button type="submit"></button>
                </form>
                <div class="name">
                    <h1>ห้องสมุดวิทยาลัยอาชีวะศึกษาสุราษฎร์ธานี</h1>
                    <img src="../IMG/22243_16061313133855.png" alt="">
                </div>
            </div>
            <div class="main-content">
            <div class="info">
                <div class="detail">
                    <div class="text">
<?php
    $bookid = $_GET['bookid'];
    $info = $conn->query("SELECT * FROM book WHERE book_id = $bookid");
    $numTotal = $conn->query("SELECT * FROM num_book WHERE book_id = $bookid");
    $numStatus = $conn->query("SELECT num_status FROM num_book WHERE book_id = $bookid and num_status = 1");
    $booked = $numStatus->num_rows;
    $bookTotal = $numTotal->num_rows;
    $remain = $bookTotal - $booked;
    foreach ($info as $row) {
        $bookname = $row['book_name'];
        $cataid = $row['catagory_id'];
        $publisher = $row['book_publisher'];
        $writer = $row['book_writer'];
        $bookedtotal = $row['book_booked_total'];
        $picture = $row['book_picture'];
        $intro = $row['book_intro'];
        $price = $row['book_price'];
        $oc = $row['book_group']; //เลขหมวด
        $numcat = $row['book_squad']; //เลขหมู่
        $locat = $row['book_location']; //สถานที่พิมพ์
        $pimyear = $row['book_year']; //ปีที่พิมพ์
        $pimnum = $row['book_pimnum']; //พิมพ์ครั้งที่
        $rscata = $conn->query("SELECT catagory_name FROM catagory WHERE catagory_id = $cataid");
        foreach ($rscata as $tag) {
            $catagory = $tag['catagory_name'];
        }
    }
?>
                        <div class="image">
                            <img src="../IMG/<?php echo $picture?>" alt="">
                        </div>
                        <div class="t-tin">
                            <h1><?php echo $bookname?></h1>
                            <h2>ประเภท : <?php echo $catagory?></h2>
                            <p id="a"><?php echo $intro?></p>
                            <div class="t-num">
                                <table>
                                    <thead>
                                    <tr>
                                            <td>จำนวนเล่ม</td>
                                            <td>คงเหลือ</td>
                                            <td>จองไปทั้งหมด</td>
                                            <td>กำลังจอง</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $bookTotal?></td>
                                            <td><?php echo $remain?></td>
                                            <td><?php echo $bookedtotal?></td>
                                            <td><?php echo $numStatus->num_rows?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="another">
                        <div class="data-book">
                            <h1>ข้อมูลหนังสือ</h1>
                            <h2><?php echo $bookname?></h2>
                            <ul>
                                <li>ผู้เขียน : <span class="red"><?php echo $writer?></span></li>
                                <li>สำนักพิมพ์ : <?php echo $publisher?></li>
                                <li>เลขหมวด : <?php echo $oc?></li>
                                <li>เลขหมู่ : <?php echo $numcat?></li>
                                <li>สถานที่พิมพ์ : <?php echo $locat?></li>
                                <li>ปีที่พิมพ์ : <?php echo $pimyear?></li>
                                <li>ราคา : <?php echo $price?> บาท</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="reccoment">
                    <h1>Reccoment</h1>
                    <ul class="rec">
                        
<?php

$random2 = $conn->query("SELECT * FROM book ORDER BY RAND()  LIMIT 6");
foreach ($random2 as $row) {
    $ranId = $row['book_id'];
    $ranPic = $row['book_picture'];
    $ranBook = $row['book_name'];
    $ranIntro = $row['book_intro'];
    echo "
        <li>
            <a href='info.php?bookid=$ranId'>
                <div class='image-rec'>
                    <img src='../IMG/$ranPic' alt=''>
                </div>
                <div class='detail-rec'>
                    <h2>$ranBook</h2>
                    <p>$ranIntro</p>
                </div>
            </a>
        </li>
    ";
}

?>
                    </ul>
                </div>
            </div>
            </div>
        </div>
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