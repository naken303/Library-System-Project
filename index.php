<?php
    session_start();
    require 'PHP/conn.php';
    date_default_timezone_set('Asia/Bangkok');
    $current_date = date('Y-m-d');
    $showBook = 8;
    isset($_GET['page']) ? $page = $_GET['page'] : $page = 0;
    if ($page > 1) {
        $start = ($page * $showBook) - $showBook;
    } else {
        $start = 0;
    }
    if (isset($_POST['search'])) {
        $strKeyword = $_POST['search'];
        $rst = $conn->query("SELECT * FROM book WHERE book_name LIKE '%$strKeyword%'");
    } else if (isset($_GET['search'])) {
        $strKeyword = $_GET['search'];
        $rst = $conn->query("SELECT * FROM book WHERE book_name LIKE '%$strKeyword%'");
    } else if (isset($_GET['tag'])) {
        $tag = $_GET['tag'];
        $rst = $conn->query("SELECT book_id FROM book WHERE catagory_id = $tag");
    } else {
        $rst = $conn->query("SELECT book_id FROM book");
    }
    if (isset($_GET['tag'])) {
        $book = $conn->query("SELECT * FROM book WHERE catagory_id = $tag ORDER BY book_id DESC LIMIT $start , $showBook");
    } else if (isset($_POST['search']) || isset($_GET['search'])) {  
        $book = $conn->query("SELECT * FROM book WHERE book_name LIKE '%$strKeyword%' ORDER BY book_id DESC LIMIT $start , $showBook");
    } else {
        $book = $conn->query("SELECT * FROM book ORDER BY book_id DESC LIMIT $start , $showBook");
    }
    $numRows = $rst->num_rows;
    $totalPages = $numRows / $showBook;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SVC | Library</title>
    <link rel="stylesheet" href="SCSS/reset.css">
    <link rel="stylesheet" href="SCSS/style.css">
    <link rel="stylesheet" href="SCSS/index.css">
    <link rel="stylesheet" href="CSS/slide2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <section>
        <nav class="pk-1" id="nav">
            <div class="menu">
                <ul class="main">
                    <h1>เมนู</h1>
                    <a href="index.php"><li class="hold"><i class="bi bi-house"></i> <p>หน้าแรก</p></li></a>
                    <a href="PHP/login.php"><li><i class="bi bi-person"></i> <p>เข้าสู่ระบบ</p></li></a>
                </ul>
                <ul class="login"></ul>
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
                    <img src="IMG/22243_16061313133855.png" alt="">
                </div>
            </div>
            <div class="main-content pk-1">
                <div class="row">
                    <div class="out-slide col-md-9">
                        <div class="slidershow-box">
                            <div class="a left"><button onclick="perSlide()"><i class="fas fa-arrow-left"></i></i></button></div>
                            <div class="a right"><button onclick="nextSlide()"><i class="fas fa-arrow-right"></i></button></div>
                            <div class="slides">    
                                <div class="slider s1" id="fisrtSlide">
                                    <img src="./assest/01.jpg" alt="">
                                </div>
                                <div class="slider">
                                    <img src="./assest/02.jpg" alt="">
                                </div>
                                <div class="slider">
                                    <img src="./assest/03.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="event-mini col-md-3">
                        <div class="t-2">
                            <div class="bgc face-page">
                            <div class="fb-page" data-href="https://www.facebook.com/ประชาสัมพันธ์วิทยาลัยอาชีวศึกษาสุราษฎร์ธานี-274795106525184" data-tabs="timeline" data-width="1000" data-height="352" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/ประชาสัมพันธ์วิทยาลัยอาชีวศึกษาสุราษฎร์ธานี-274795106525184" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/facebook"></a></blockquote></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shelf">
                    <h3>ได้รับความนิยม</h3>
                    <h5>popular</h5>
                    <div class="popular row g-2">
<?php
    $booked = $conn->query("SELECT * FROM book ORDER BY book_booked_total DESC LIMIT 8 ");
    foreach ($booked as $row) {
        $book_id = $row['book_id'];
        $book_picture = $row['book_picture'];
        $book_name = $row['book_name'];
        $book_intro = $row['book_intro'];
        $book_booked_total = $row['book_booked_total'];
        echo "
        <div class='out-p col-xxl-3 col-xl-4 col-md-6'>
            <a href='PHP/info.php?bookid=$book_id' class='box-p'>
                <div class='img-p'>
                    <img src='IMG/$book_picture' alt=''>
                </div>
                <div class='text-p'>
                    <h4>$book_name</h4>
                    <h5>จำนวนการยืม : $book_booked_total ครั้ง</h5>
                    <p>$book_intro</p>
                </div>
            </a>
        </div>
        ";
    }
?>
                    </div>
                </div>
                <div class="shelf">
                    <h3>อัพเดทล่าสุด</h3>
                    <h5>new update</h5>
                     <div class="book row">
                        <div class="gory col-lg-3 pk-1">
                            <h6>ประเภทหนังสือ</h6>
                            <p>Catagory</p>
                            <ul>
                            <a href="index.php" class="<?php if (!isset($tag)) {echo 'active';}?>"><p>หนังสือทั้งหมด</p></li></a>
                            <?php
    $catagory = $conn->query("SELECT * FROM catagory");
    
    foreach ($catagory as $cey) {
        $catagory_id = $cey['catagory_id'];
        $catagory_name = $cey['catagory_name'];
        if (isset($tag)) {
            if ($catagory_id === $tag) {
                $hold = "active";
                echo "
                    <a href='index.php?tag=$catagory_id' class='$hold'><p>$catagory_name</p></a>
                ";
            } else {
                $hold = "none";
                echo "
                    <a href='index.php?tag=$catagory_id'><p>$catagory_name</p></a>
                ";
            }
        } else {
            echo "
                <a href='index.php?tag=$catagory_id'><p>$catagory_name</p></a>
            ";
        }
    }
?>
                            </ul>
                        </div>
                        <div class="booklist col-lg-9">
                            <div class='book row'>
<?php
    foreach ($book as $row) {
        $book_id = $row['book_id'];
        $book_picture = $row['book_picture'];
        $book_name = $row['book_name'];
        $book_intro = $row['book_intro'];
        echo "
                                <a href='PHP/info.php?bookid=$book_id' class='col-xxl-3 col-xl-4 col-md-6'>
                                    <div class='img-bor'>
                                        <img src='IMG/$book_picture' alt=''>
                                    </div>
                                    <div class='bottom-card'>
                                        <h1>$book_name</h1>
                                        <p>$book_intro</p>
                                    </div>
                                </a>
        ";
    }
?>
                            </div>
                            <div class="page">
                                <ul>
<?php
    for ($btp = 1; $btp <= $totalPages + 1; $btp++) {
        if (isset($tag)) {
            if ($btp == $page) {
                echo "<li class='active'><a href='?tag=$tag&page=$btp'>$btp</a></li>";
            } else {
                echo "<li><a href='?tag=$tag&page=$btp'>$btp</a></li>";
            }
        } else if (isset($_POST['search']) || isset($_GET['search'])) {
            if (isset($_POST['search'])) {
                $teemo = $_POST['search'];
            } else {
                $teemo = $_GET['search'];
            }
            if ($btp == $page) {
                echo "<li class='active'><a href='?search=$teemo&page=$btp'>$btp</a></li>";
            } else {
                echo "<li><a href='?search=$teemo&page=$btp'>$btp</a></li>";
            }
        } else {
            if ($btp == $page) {
                echo "<li class='active'><a href='?page=$btp'>$btp</a></li>";
            } else {
                echo "<li><a href='?page=$btp'>$btp</a></li>";
            }
        }
    }
?>
                                </ul>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
        
    </section>
    <script>
        let box = document.getElementById("fisrtSlide");
        function nextSlide() {
            if (box.style.marginLeft == "0%") {
                box.style.marginLeft = "-20%";
            } else if (box.style.marginLeft == "-20%") {
                box.style.marginLeft = "-40%";
            } else {
                box.style.marginLeft = "0%";
            }
        }
        function perSlide() {
            if (box.style.marginLeft == "0%") {
                box.style.marginLeft = "-40%";
            } else if (box.style.marginLeft == "-20%") {
                box.style.marginLeft = "0%";
            } else {
                box.style.marginLeft = "-20%";
            }
        }
        setInterval(nextSlide ,5500);
    </script>
    <div id="fb-root"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v10.0&appId=164541391548273&autoLogAppEvents=1" nonce="Rgx8ry7n"></script>
</body>
</html>