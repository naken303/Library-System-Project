<?php
    date_default_timezone_set('Asia/Bangkok');
    $dateday = date('Y-m-d');
    $datetime = date('H:i:s');
    require '../conn.php';
    require 'session.php';
    if (isset($_POST['psubmit'])) {
        $book_id = $_POST['pbook_id'];
        $pnum = $_POST['pnum'];
        for ($e = 0; $e < $pnum; $e++) { 
                $barcode = $_POST["pbarcode$e"];
                $plusNum = $conn->query("INSERT INTO num_book (num_id , barcode ,book_id , num_status , studen_id) VALUE ('','$barcode','$book_id','0','0')");
        }
?>
    <script>
        alert("เพิ่มจำนวนเล่มสำเร็จ");
        location.href="a_book.php"
    </script>
<?php
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddNumBook | book barcode scan</title>
    <style>
        * {box-sizing: border-box;}
        body {background: #36393F;}
        .button {
            margin-top: 1em; border: 1px solid #000; border-radius: 5px; cursor: pointer; padding: 5px; font-size: 12px; transition: 0.3s ease; width: fit-content;
        }
        .button:hover {
            background: #bdbdbd;
        }
        a {margin-top: 1em; text-decoration: none; border: 1px solid #ff0000; background: #ff0000; cursor: pointer; color: #ffffff; border-radius: 5px; padding: 5px; font-size: 12px; transition: 0.3s ease;}
        a:hover {background: #ac0000;}
        form {max-width: fit-content; margin: 0 auto; padding: 2em; border-radius: 15px; background: #ffffff;}
        p , label , h1 {color: #000;}
        input {width: 100%; padding: 5px 10px; border-radius: 5px;}
        input:focus {background: #bdbdbd;}
    </style>
</head>
<body>
    <form action="card_add.php" method="post">
        <h1>เพิ่มจำนวนเล่มโดยใส่เลขทะเบียน</h1>
        <p></p>
        <label>บาร์โค้ดหนังสือ</label><br>
<?php
    if (isset($_GET['no'])) {
        $x = 1;
        $no = $_GET['no'];
        $bid = $_GET['bid'];
        echo "<input type='hidden' name='pbook_id' value='$bid'><input type='hidden' name='pnum' value='$no'><input type='hidden' name='psubmit'>";
        for ($i = 0; $i < $no; $i++) { 
            echo "เล่มที่ $x<input type='text' name='pbarcode$i' class='myInput' style='display: block;' autofocus required autocomplete='off' MaxLength='7'>";
            $x++;
        }
    } else if (isset($_POST['plus_num']) && isset($_POST['plus_name'])) {
        $x = 1;
        $num = $_POST['plus_num'];
        $book_id = $_POST['plus_name'];
        echo "<input type='hidden' name='pbook_id' value='$book_id'><input type='hidden' name='pnum' value='$num'><input type='hidden' name='psubmit'>";
        for ($i = 0; $i < $num; $i++) { 
            echo "เล่มที่ $x<input type='text' name='pbarcode$i' class='myInput' style='display: block;' autofocus required autocomplete='off' MaxLength='7'>";
            $x++;
        }
        
    }
    echo "<button type='submit' class='button' >ยืนยัน</button>";
?>
        
        
        <a href="a_book.php">กลับ</a>
    </form>
    <script src="../../JS/jquery.js"></script>
    <script>
        $(".myInput").keyup(function () {
            if (this.value.length == this.maxLength) {
            $(this).next('input').focus();
            }
        });
    </script>
</body>
</html>