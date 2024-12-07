<?php
    require '../conn.php';
    require 'session.php';
    $bookname = $_POST['aName']; //ชิ้อหนังสือ
    $writer = $_POST['aWriter']; //ผู้เขียน
    $publisher = $_POST['aPublisher']; //สำนักพิมพ์
    $num = $_POST['aNum']; //จำนวนเล่ม
    $intro = $_POST['aIntro']; //เรื่องย่อ
    $cata = $_POST['aCata']; //ประเภท

    $price = $_POST['aPrice']; //ราคา
    $oc = $_POST['aNumOc']; //เลขหมวด
    $numcat = $_POST['aNumCat']; //เลขหมู่
    $locat = $_POST['aLocatPub']; //สถานที่พิมพ์
    $pimyear = $_POST['aYearPim']; //ปีที่พิมพ์
    $pimnum = $_POST['aPimNum']; //พิมพ์ครั้งที่

    if (file_exists($_FILES['aImage']['tmp_name'])) {
        $image = $_FILES['aImage']['name'];
        $target = "../../IMG/".basename($image);
        $confirm = move_uploaded_file($_FILES['aImage']['tmp_name'], $target);
        if ($confirm) {
            $insert = $conn->query("INSERT INTO book (book_id, book_name, book_publisher, book_writer, book_picture, book_intro, book_group, book_squad, book_location, book_year, book_pimnum, book_price, catagory_id) VALUE ('','$bookname','$publisher','$writer','$image','$intro','$oc','$numcat','$locat','$pimyear','$pimnum','$price','$cata')");
            if ($insert) {
                $selbo = $conn->query("SELECT book_id FROM book WHERE book_name = '$bookname'");
                foreach ($selbo as $kayn) {
                    $book_plus = $kayn['book_id'];
                }
                header("location:card_add.php?no=$num&bid=$book_plus");                
            } else {
?>
                <script>
                    alert("อัพโหลดข้อมูลล้มเหลว");
                    location.href="a_book.php";
                </script>
<?php            
            }
        } else {
?>
            <script>
                alert("อัพโหลดรูปภาพล้มเหลว");
                location.href="a_book.php";
            </script>
<?php
        }
    } else {
        $insert = $conn->query("INSERT INTO book (book_id, book_name, book_publisher, book_writer, book_intro, book_group, book_squad, book_location, book_year, book_pimnum, book_price, catagory_id) VALUE ('','$bookname','$publisher','$writer','$intro','$oc','$numcat','$locat','$pimyear','$pimnum','$price','$cata')");
        if ($insert) {
            $selbo = $conn->query("SELECT book_id FROM book WHERE book_name = '$bookname'");
                foreach ($selbo as $kayn) {
                    $book_plus = $kayn['book_id'];
                }
                header("location:card_add.php?no=$num&bid=$book_plus");                
        } else {
?>
            <script>
                alert("อัพโหลดข้อมูลล้มเหลว");
                location.href="a_book.php";
            </script>
<?php            
        }
    }
?>