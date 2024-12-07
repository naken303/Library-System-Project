<?php
    require "../conn.php";
    $book_id = $_POST["bookid"];
    $bookname = $_POST["bookname"];
    $writer = $_POST["writer"];
    $publiser = $_POST["publisher"];
    $intro = $_POST["intro"];

    $price = $_POST['price']; //ราคา
    $oc = $_POST['numOc']; //เลขหมวด
    $numcat = $_POST['numCat']; //เลขหมู่
    $locat = $_POST['locatPub']; //สถานที่พิมพ์
    $pimyear = $_POST['yearPim']; //ปีที่พิมพ์
    $pimnum = $_POST['pimNum']; //พิมพ์ครั้งที่

    $catagory = $_POST["catagory"];
    if (file_exists($_FILES['image']['tmp_name'])) {
        $pickPic = $conn->query("SELECT book_picture FROM book WHERE book_id = $book_id");
        foreach ($pickPic as $row) {
            $dePic = $row['book_picture'];
        }
        if ($dePic != '') {
            $removeOldPicture = unlink("../../IMG/$dePic");
            if ($removeOldPicture) {
                $image = $_FILES['image']['name'];
                $target = "../../IMG/".basename($image);
                $confirm = move_uploaded_file($_FILES['image']['tmp_name'], $target);
                if ($confirm) {
                    $rs = $conn->query("UPDATE book SET book_name = '$bookname', book_publisher =  '$publiser', book_writer = '$writer', book_intro = '$intro', book_picture = '$image' , book_group = '$oc' , book_squad = '$numcat' , book_location = '$locat' , book_year = '$pimyear' , book_pimnum = '$pimnum' , book_price = '$price' , catagory_id = '$catagory' WHERE book_id = $book_id");
?>
                    <script>
                        alert("แก้ไขสำเร็จ");
                        location.href="a_book.php";
                    </script>
<?php
                } else {
?>
                    <script>
                        alert("เพิ่มรูปภาพไม่สำเร็จ");
                        location.href="a_book.php";
                    </script>
<?php
                }
            } else {
?>
                <script>
                    alert("ลบรูปภาพเดิมล้มเหลว");
                    location.href="a_book.php";
                </script>
<?php
            }
        } else {
            $image = $_FILES['image']['name'];
            $target = "../../IMG/".basename($image);
            $confirm = move_uploaded_file($_FILES['image']['tmp_name'], $target);
            if ($confirm) {
                $rs = $conn->query("UPDATE book SET book_name = '$bookname', book_publisher =  '$publiser', book_writer = '$writer', book_intro = '$intro', book_picture = '$image' , book_group = '$oc' , book_squad = '$numcat' , book_location = '$locat' , book_year = '$pimyear' , book_pimnum = '$pimnum' , book_price = '$price' , catagory_id = '$catagory' WHERE book_id = $book_id");
                if ($rs) {
?>
                    <script>
                        alert("แก้ไขเสร็จสิ้น");
                        location.href="a_book.php";
                    </script>
<?php
                }
            } else {
?>
                <script>
                    alert("เพิ่มรูปภาพไม่สำเร็จ");
                    location.href="a_book.php";
                </script>
<?php
            }
        }
    } else {
        $rs = $conn->query("UPDATE book SET book_name = '$bookname', book_publisher =  '$publiser', book_writer = '$writer', book_intro = '$intro', book_group = '$oc' , book_squad = '$numcat' , book_location = '$locat' , book_year = '$pimyear' , book_pimnum = '$pimnum' , book_price = '$price' , catagory_id = $catagory WHERE book_id = $book_id");
        if ($rs) {
?>
            <script>
                alert("แก้ไขเสร็จสิ้น");
                location.href="a_book.php";
            </script>
<?php
        } else {
?>
            <script>
                alert("แก้ไขล้มเหลว");
                location.href="a_book.php";
            </script>
<?php
        }
    }
?>