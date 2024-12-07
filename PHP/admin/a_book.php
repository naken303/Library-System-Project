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
                    <a href="a_book.php"><li class="hold"><i class="bi bi-journal-text"></i> รายการหนังสือ <p><?php echo $total_have_book?></p></li></a>
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
            <div class="outTable">
                <div class="shadow <?php if (isset($_GET['id']) || isset($_GET['del']) || isset($_GET['list']) || isset($_GET['cata'])) {echo 'active';}?>" id="shadow" onclick="closeX()"></div>
                <button class="addMenu" onclick="openX()">เพิ่มหนังสือ</button>
                <button class="addMenu" onclick="openL()">เพิ่มประเภทหนังสือ</button>
                <table id="myTable">
                    <thead>
                        <tr>
                            <td>ชื่อหนังสือ</td>
                            <td>จำนวนเล่มทั้งหมด</td>
                            <td>คงเหลือ</td>
                            <td>กำลังยืม</td>
                            <td>ยอดยืมสะสม</td>
                            <td></td>
                        </tr>
                    </thead>

                    <tbody>
<?php
    $bookShow = $conn->query("SELECT * FROM book");
    
    foreach ($bookShow as $row) {
        $book_id = $row["book_id"];
        $book_name = $row["book_name"];
        $booked_total = $row["book_booked_total"];
        $numTotal = $conn->query("SELECT * FROM num_book WHERE book_id = $book_id");
        $numStatus = $conn->query("SELECT num_status FROM num_book WHERE book_id = $book_id and num_status = 1");
        $booked = $numStatus->num_rows;
        $bookTotal = $numTotal->num_rows;
        $remain = $bookTotal - $booked;
        
?>
                        <tr>
                            <td><?php echo $book_name?></td>
                            <td><a href="?list=<?php echo $book_id?>"><?php echo $bookTotal?></a></td>
                            <td><?php echo $remain?></td>
                            <td><?php echo $booked?></td>
                            <td><?php echo $booked_total?></td>
                            <td>
                                <a href="?id=<?php echo $book_id?>">แก้ไข</a>
                                <a href="?del=<?php echo $book_id?>">ลบ</a>
                            </td>
                        </tr>
<?php
    }
?>
                    </tbody>
                </table>
                <div class="control" id="control">
                    <div class="add" id="add">
                        <form action="ps_add.php" method="POST" enctype="multipart/form-data">
                        <div class="img">
                            <img src="#" alt="" id="blah">
                            <input type="file" name="aImage"  onchange="readURL(this);">
                        </div>
                        <div class="info">
                            <div class="form">
                                <input type="text" class="text" name="aName"  placeholder="ชื่อหนังสือ" required>
                                <input type="text" class="text" name="aNumOc"  placeholder="เลขหมวด" required>
                                <input type="text" class="text" name="aNumCat"  placeholder="เลขหมู่" required>
                                <input type="text" class="text" name="aWriter"  placeholder="ผู้แต่ง" required>
                                <input type="text" class="text" name="aPublisher"  placeholder="สำนักพิมพ์" required>
                                <input type="text" class="text" name="aLocatPub"  placeholder="สถานที่พิมพ์" required>
                                <input type="text" class="text" name="aYearPim"  placeholder="ปีที่พิมพ์" required>
                                <input type="number" class="text" name="aPimNum"  placeholder="พิมพ์ครั้งที่" required>
                                
                                
                                
                                <label>เรื่องย่อ</label>
                                <textarea name="aIntro"  cols="30" rows="10"></textarea>
                                <div class="selt">
                                    <label>ประเภท</label>
                                    <select name="aCata" >
<?php
    $cata = $conn->query("SELECT * FROM catagory");
    foreach ($cata as $type) {
        $cata_id = $type['catagory_id'];
        $cata_name = $type['catagory_name'];
        echo "<option value='$cata_id'>$cata_name</option>";
    }
?>
                                    </select>
                                </div>
                                <div class="selt">
                                    <label>จำนวน</label>
                                    <input type="number" name="aNum"  placeholder="0" required>
                                    <label>เล่ม</label>
                                </div>
                                <div class="selt">
                                    <label>ราคา</label>
                                    <input type="number" name="aPrice" id="money" placeholder="0" required>
                                    <label>บาท</label>
                                </div>
                                
                                <button>ยืนยัน</button>
                            </div>
                        </form>
                        </div>
                    </div>
                    <div class="add <?php if (isset($_GET['cata'])) {echo 'active';} ?>" id="asd">
                        <form action="ps_cata.php?catadd" method="POST" enctype="multipart/form-data">
                        <div class="info">
                            <div class="form">
                                <label>เพิ่มประเภทหนังสือ</label>
                                <input type="text" class="text" name="addcata"  placeholder="พิมพ์ชื่อประเภท" required>
                                <button>ยืนยัน</button>
                            </div>
                        </div>
                        </form>
                        <form action="ps_cata.php?catadel" method="post">
                            <div class="info" id="cata">
                                <div class="selt">
                                    <label>ประเภทที่มีอยู่</label>
                                    <select name="delcata" >
<?php
    $cata = $conn->query("SELECT * FROM catagory");
    foreach ($cata as $type) {
        $cata_id = $type['catagory_id'];
        $cata_name = $type['catagory_name'];
        echo "<option value='$cata_id'>$cata_name</option>";
    }
?>
                                    </select>
                                    <button type="submit" class="cata-del">ลบ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="control" id="idot">
<?php
    if (isset($_GET['id'])) {
        $ids = $_GET['id'];
        $eed = $conn->query("SELECT * FROM book WHERE book_id = '$ids'");
        foreach($eed as $edit) {
            $eName = $edit['book_name'];
            $eWrite = $edit['book_writer'];
            $ePublis = $edit['book_publisher'];
            $eIntro = $edit['book_intro'];
            $ePic = $edit['book_picture'];

            $ePrice = $edit['book_price']; //ราคา
            $eOc = $edit['book_group']; //เลขหมวด
            $eNumcat = $edit['book_squad']; //เลขหมู่
            $eLocat = $edit['book_location']; //สถานที่พิมพ์
            $ePimyear = $edit['book_year']; //ปีที่พิมพ์
            $ePimnum = $edit['book_pimnum']; //พิมพ์ครั้งที่
        }
    }
?>
                    <div class="edit <?php if (isset($_GET['id'])) {echo 'active';} ?>" id="edit">
                        <form action="ps.php" method="post" enctype="multipart/form-data">
                            <div class="img">
                                <img src="../../IMG/<?php echo $ePic?>">
                                <input type="file" name="image">
                            </div>
                            <div class="info">
                                <div class="form">
                                    <input type="hidden" name="bookid" value="<?php echo $_GET['id']?>">
                                    <label for="">ชื่อหนังสือ</label>
                                    <input type="text" class="text" name="bookname" value="<?php echo $eName?>" maxlength="100" required>
                                    <label for="">เลขหมวด</label>
                                    <input type="text" class="text" name="numOc" value="<?php echo $eOc?>" maxlength="20" required>
                                    <label for="">เลขหมู่</label>
                                    <input type="text" class="text" name="numCat" value="<?php echo $eNumcat?>" maxlength="20" required>
                                    <label for="">ผู้แต่ง</label>
                                    <input type="text" class="text" name="writer" value="<?php echo $eWrite?>" maxlength="40" required>
                                    <label for="">สำนักพิมพ์</label>
                                    <input type="text" class="text" name="publisher" value="<?php echo $ePublis?>" maxlength="40" required>
                                    <label for="">สถานที่พิมพ์</label>
                                    <input type="text" class="text" name="locatPub" value="<?php echo $eLocat?>" maxlength="200" required>
                                    <label for="">ปีที่พิมพ์</label>
                                    <input type="text" class="text" name="yearPim" value="<?php echo $ePimyear?>" maxlength="4" required>
                                    <label for="">พิมพ์ครั้งที่</label>
                                    <input type="text" class="text" name="pimNum" value="<?php echo $ePimnum?>" maxlength="4" required>
                                    <label>เรื่องย่อ</label>
                                    <textarea name="intro" class="text" cols="30" rows="10"><?php echo $eIntro?></textarea>
                                    <div class="selt">
                                        <label>ประเภท</label>
                                        <select name="catagory">
<?php
    $cata = $conn->query("SELECT * FROM catagory");
    foreach ($cata as $type) {
        $cata_id = $type['catagory_id'];
        $cata_name = $type['catagory_name'];
        echo "<option value='$cata_id'>$cata_name</option>";
    }
?>
                                        </select>
                                    </div>
                                    <div class="selt">
                                        <label>ราคา</label>
                                        <input type="number" name="price" id="money" value="<?php echo $ePrice;?>" maxlength="5" required>
                                        <label>บาท</label>
                                    </div>
                                    <button type="submit">ยืนยัน</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="remove <?php if (isset($_GET['del'])) {echo 'active';} ?>" id="re">
                        <div class="box-r">
                            <h1>คุณต้องการยืนยันการลบหนังสือหรือไม่</h1>
                            <div class="btn-r">
                                <form action="ps_del.php" method="POST">
                                    <input type="hidden" name="dell" value="<?php echo $_GET['del']?>">
                                    <button type="submit">ใช่</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="list <?php if (isset($_GET['list'])) {echo 'active';} ?>" id="list">
                        <div class="party" id="book">
<?php
    $list = $_GET['list'];
    $book_list = $conn->query("SELECT * FROM book WHERE book_id = $list");
    foreach ($book_list as $xayah) {
        $l_bookname = $xayah['book_name'];
    }
    $num_list = $conn->query("SELECT * FROM num_book WHERE book_id = $list");
    $s = $conn->query("SELECT num_status FROM num_book WHERE book_id = $list and num_status = 1")->num_rows;
    $e = $conn->query("SELECT num_status FROM num_book WHERE book_id = $list and num_status = 0")->num_rows;
?>
                            <div class="book-name">
                                <div>
                                    <h1><?php echo $l_bookname?></h1>
                                    <p>ว่าง <?php echo $e?> ถูกยืม <?php echo $s?> </p>
                                </div>
                                <div class="rem">
                                    <p><?php echo $num_list->num_rows;?> เล่ม</p><form action="card_add.php" method="post" class="plus" id="plus"><i class="fas fa-plus" onclick="plusNum()"></i><input type="hidden" name="plus_name" value="<?php echo $list?>"><input type="number" name="plus_num"><button type="submit">ยืนยัน</button></form>
                                </div>
                            </div>
                            <div class="num-book">
<?php
    foreach ($num_list as $rakan) {
        $num_id = $rakan['num_id'];
        $barcode = $rakan['barcode'];
        $studen_id = $rakan['studen_id'];
        $num_status = $rakan['num_status'];
        if ($num_status == 0) {
            $status = 'ว่าง';
            echo "
                <a href='?list=$list&booking=$barcode' class='sum-b'>
                    <h1>ID : $barcode</h1>
                    <h2>สถานะ : <span style='color: #54FF87;'>$status</span></h2>
                </a>
            ";
        } else if ($num_status == 1) {
            $status = 'ถูกยืม';
            echo "
                <a href='?list=$list&studen=$studen_id&numid=$num_id' class='sum-b'>
                    <h1>ID : $barcode</h1>
                    <h2>สถานะ : <span style='color: #FF5353;'>$status</span></h2>
                </a>
            ";
        }
    }
?>
                            </div>
                        </div>
                        <div class="booked <?php if (isset($_GET['studen'])) {echo 'active';}?>">
<?php
    $studen = $_GET['studen'];
    $numid = $_GET['numid'];
    $dateBooked = $conn->query("SELECT num_booking , num_return FROM num_book WHERE num_id = $numid and studen_id = $studen");
    foreach ($dateBooked as $hole) {
        $date_booking = $hole['num_booking'];
        $date_return = $hole['num_return'];
    }
    $studenbooked = $conn->query("SELECT * FROM studen WHERE studen_id = $studen");
    foreach ($studenbooked as $yone) {
        $studen_key = $yone['studen_key'];
        $studen_name = $yone['studen_name'];
        $department_id = $yone['department_id'];
        $studen_class = $yone['studen_class'];
        $department = $conn->query("SELECT department_name FROM department WHERE department_id = $department_id");
        foreach ($department as $dpm) {
            $department_name = $dpm['department_name'];
        }
    }
?>
                            <table>
                                <thead>
                                    <tr>
                                        <td>ชื่อ</td>
                                        <td>ชั้น</td>
                                        <td>แผนก</td>
                                        <td>รหัสนักเรียน</td>
                                        <td>วันที่ยืม</td>
                                        <td>วันที่ต้องคืน</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $studen_name?></td>
                                        <td><?php echo $studen_class?></td>
                                        <td><?php echo $department_name?></td>
                                        <td><?php echo $studen_key?></td>
                                        <td><?php echo date('d/m/Y',strtotime($date_booking));?></td>
                                        <td <?php if ($current_date > $date_return) {echo "style='color: #ff4b4b;'";}?>><?php echo date('d/m/Y',strtotime($date_return));?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="switch">
                                <a class="red" href="ps_return.php?retu=<?php echo $numid?>&stukey=<?php echo $studen?>">คืนหนังสือ</a>
                            </div>
                        </div>
                        <div class="booking <?php if (isset($_GET['booking'])) {echo 'active';}?>">
<?php
    $br = $_GET['booking'];
?>
                            <form action="ps_booking.php" method="post">
                                <div>
                                    <input type="hidden" name="num_id" value="<?php echo $br?>">
                                    <label>รหัสนักเรียน</label>
                                    <input type="number" name="studen_key" placeholder="เช่น 62202040054">
                                    <label>วันที่ต้องคืน</label>
                                    <input type="date" name="num_return">
                                </div>
                                <div class="switch">
                                    <button class="green" type="submit">ยืมหนังสือ</button>
                                    <a href="ps_numdel.php?bruh=<?php echo $br?>" class="red">ลบหนังสือ</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </section>
    <script src="../../JS/jquery.js"></script>
    <script src="../../JS/table.js"></script>
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

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        let list = document.getElementById("list");
        let shadow = document.getElementById("shadow");
        let add = document.getElementById("add");
        let asd = document.getElementById("asd");
        let re =  document.getElementById("re");
        let edit =  document.getElementById("edit"); 
        function openX() {
            add.classList.add("active");
            shadow.classList.add("active");
        }
        function openL() {
            asd.classList.add("active");
            shadow.classList.add("active");
        }
        function closeX() {
            add.classList.remove("active");
            asd.classList.remove("active");
            shadow.classList.remove("active");
            edit.classList.remove("active");
            re.classList.remove("active");
            list.classList.remove("active");
        }
        let plus = document.getElementById("plus");
        function plusNum() {
            plus.classList.toggle("active");
        } 
    </script>
</body>
</html>