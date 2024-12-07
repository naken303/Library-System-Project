<?php
    require '../conn.php';
    $studenname = $_POST['studenname'];
    $studenkey = $_POST['studenkey'];
    $studendate = $_POST['studendate'];
    $studenclass = $_POST['studenclass'];
    $department = $_POST['department'];
    
    $check = $conn->query("SELECT * FROM studen WHERE studen_name = '$studenname' OR studen_key = $studenkey")->num_rows;
    if ($check > 0) {
?>
    <script>
        alert("มีนักเรียนอยู่ในฐานข้อมูลแล้ว");
        window.location.href="a_member.php";
    </script>
<?php
    } else {
        $image = $_FILES['image']['name'];
        $target = "../../IMG/studen/".basename($image);
        $confirm = move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $rs = $conn->query("INSERT INTO studen (studen_id, studen_key, studen_date, studen_name, department_id, studen_class, studen_booked_total) VALUE ('','$studenkey','$studendate','$studenname','$department','$studenclass','0')");
        if ($rs) {
            rename("../../IMG/studen/$image","../../IMG/studen/$studenkey.jpg");
?>
            <script>
                alert("เพิ่มสำเร็จ");
                window.location.href="a_member.php";
            </script>
<?php
        } else {
?>
        <script>
            alert("เพิ่มล้มเหลว");
            window.location.href="a_member.php";
        </script>
<?php
        }
    }
?>