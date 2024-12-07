<?php
    date_default_timezone_set('Asia/Bangkok');
    $dateday = date('Y-m-d');
    $datetime = date('H:i:s');
    require '../conn.php';
    require 'session.php';
    if (isset($_POST['barcode'])) {
        $barcode = $_POST['barcode'];
        $std = $conn->query("SELECT studen_id , department_id , studen_name FROM studen WHERE studen_key = $barcode");
        if ($std->num_rows > 0) {
            foreach ($std as $row) {
                $studen_id = $row['studen_id'];
                $department_id = $row['department_id'];
                $studen_name = $row['studen_name'];
            }
            $rs = $conn->query("INSERT INTO record (record_id,record_date,record_time,studen_id,department_id) VALUE ('','$dateday','$datetime','$studen_id','$department_id')");
            header("location:card.php?name=$studen_name&date=$dateday&time=$datetime&id=$barcode");
        } else {
            header("location:card.php");
                       
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libary | barcode scan</title>
    <link rel="stylesheet" href="../../CSS/card.css">
</head>
<body>
    <div class="center">
        <form action="card.php" method="post">
            
            
    <?php
            if (isset($_GET['name']) && isset($_GET['date'])  && isset($_GET['time']) && isset($_GET['id'])) {
                $iss = $_GET['name'];
                $date = $_GET['date'];
                $time = $_GET['time'];
                $id = $_GET['id'];
                echo "
                <div class='text'>
                    <h1>$iss</h1>
                    <h1>$date | $time</h1>
                </div>
                <div class='img'>
                    <img src='../../IMG/studen/$id.jpg' alt=>
                </div>
                ";
            } else {
                echo "<h1>ไม่มีนักเรียนในระบบ<h1>";
            }
    ?>

            <input type="text" name="barcode" onchange="form.submit()" placeholder="รหัสนักเรียน" autofocus>
        </form>
        <!-- <button onclick="closeTab()">ปิดการใช้งาน</button> -->
    </div>
    <script>
        function closeTab() {
            if (confirm("ต้องการจะปิดการใช้งาน?")) {
                close();
            }
        }
    </script>
</body>
</html>