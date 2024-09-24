<?php

require '../server/config.php';

session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('location: login.php');
    exit;
}

    //echo $_SESSION['login'];
    $s_id = $_SESSION['student_id'];
    $s_fName = $_SESSION['s_firstName'];
    $s_lName = $_SESSION['s_lastName'];
    $s_phoneNo = $_SESSION['s_phoneNo'];
    $s_email = $_SESSION['s_email'];

    /********************************Notifation*****************************************/

    $noti = "SELECT req_notifi.id, req_notifi.text, req_fulfill.fill_by_student_id
                FROM req_notifi 
                JOIN req_fulfill ON req_notifi.fill_id = req_fulfill.fulfill_id 
                JOIN req_book ON req_fulfill.req_id = req_book.req_id 
                WHERE req_book.req_student_id = '$s_id' AND req_notifi.status = 0";

    $query_noti = $conn->query($noti);
    $count = $query_noti->num_rows;

    /****************************for page****************************************************/

    $num_per_page = 8;

    if(isset($_GET["pages"])){

        $pages = $_GET["pages"];

        $pages_pre = $pages - 1;
        $pages_next = $pages + 1;


    }else{
        $pages = 1;
        $pages_pre = 0;
        $pages_next = 2;
    }

    $start_from=($pages-1)*8;

    $page = "SELECT * FROM `booksell` WHERE `status` = '1' ORDER BY sell_id DESC";
    $query_page = $conn->query($page);
    $total_rec = mysqli_num_rows($query_page);
    //echo $total_rec;
    $total_page = ceil($total_rec/$num_per_page);
    //echo $total_page;

    /************************************************************** */    



    $sql = "SELECT * FROM `booksell` WHERE `status` = '1' ORDER BY sell_id DESC LIMIT $start_from,$num_per_page;";
    //$sql = "SELECT * FROM `booksell` WhERE `student_id` = 'S02' ORDER BY sell_id DESC";

    $result = $conn->query($sql);

    //for search
    if (isset($_POST['search_submit'])){

        $search = $_POST['search'];
        $sql= "SELECT * FROM `booksell` WHERE `book_name` LIKE '%$search%' AND `status` = '1' ORDER BY sell_id DESC LIMIT $start_from,$num_per_page;";

    } else{
        $sql = "SELECT * FROM `booksell` WHERE `status` = '1' ORDER BY sell_id DESC LIMIT $start_from,$num_per_page;";
        //$sql = "SELECT * FROM `booksell` WhERE `student_id` = 'S02' ORDER BY sell_id DESC";

        $search = "";
    
    }
    
    $result = $conn->query($sql);


?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Book Buy</title>
<link rel="stylesheet" href="../css/main.css?v=<?=$version?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/d4c3426ce2.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

</head>

<body style="background-color: #f2f6ff;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container-fluid" style="margin-left:50px">

            <a class="navbar-brand" href="#">East West University</a>

            <ul class="navbar-nav" style="margin-right:100px">

                <a href="" class="text-dark mx-3">
                    <i class="fas fa-envelope fa-2x"></i>
                    <span class="badge bg-danger badge-dot"></span>
                </a>

            
                <li class="nav-item dropdown" style="margin-right: 30px;">

                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 30px;">
                        <span class="material-symbols-outlined">
                            mail
                        </span>
                        <?php
                            if($count == 0){
                                echo "";
                            }else{
                                echo "
                                <span class='badge bg-danger' id='count'>
                                    $count
                                    </span>
                                ";
                            }
                            
                        ?>
                    </a>
                    

                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">

                        <?php
                            if($query_noti->num_rows > 0){

                                while($row = $query_noti->fetch_assoc()){

                                    echo "<a class='dropdown-item text-primary' href='notification.php?id=$row[id]'>
                                                <b style='color:#FFFCFC;'>$row[text] by $row[fill_by_student_id]</b>
                                        </a>";

                                }

                            }else{

                                echo "<li><a class='dropdown-item' href='#'>
                                                <span class='material-symbols-outlined'>
                                                    sentiment_sad
                                                </span>
                                                Sorry! no message
                                            </a>
                                        </li>
                                        <br>
                                        <li>
                                            <a class='dropdown-item' href='notification.php'>
                                                view all Notification
                                            </a>

                                        </li>";
                                
                            }
                        ?>

                    </ul>

                </li>
                

            
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $s_fName ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>

                
            </ul>

        </div>
    </nav>


    <div style="font-size:20px;">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

            <div class="container-fluid" style="margin-left:70px;">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="home.php">Home</a>
                        </li>
                        <li class="nav-item"  style="margin-left:30px">
                            <a class="nav-link active" href="bookBuy.php">Book Buy</a>
                        </li>
                        <li class="nav-item"  style="margin-left:30px">
                            <a class="nav-link" href="bookSell.php">Book Sell</a>
                        </li>
                        <li class="nav-item dropdown" style="margin-left:30px">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Book Request
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="req_book.php">Request for book</a></li>
                                <li><a class="dropdown-item" href="all_req.php">All request</a></li>
                                <li><a class="dropdown-item" href="my_req.php">My request</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"  style="margin-left:30px">
                            <a class="nav-link" href="info.php">Info</a>
                        </li>
                
                    </ul>
                </div>

            </div>

        </nav>

    </div>

<div class="container">

    <section>
        
        <div style="padding-top: 25px;">

            <form class="d-flex" role="search" action="bookBuy.php" method="POST">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php echo $search?>">
                <button class="btn btn-outline-success" type="submit" name="search_submit">Search</button>
            </form>


            <div class="row gy-3 my-3">




                <?php
/*****************************************for book list*********************************************************** */

                    if ($result->num_rows > 0) {
                        
                        while($row = $result->fetch_assoc()){

                            echo "
                                <div class='col-sm-6 col-md-4 col-lg-3'>

                                    <div class='card' style='width: 15rem;'>

                                        <div class='inner'>
                                            <img src='$row[book_img]' height='230px' class='card-img-top' alt='Image'>
                                        </div>

                                        <div class='card-body'>
                                            <h5 class='card-title'> <b> $row[book_name] </b></h5>
                                            <p class='card-text'> Price BDT $row[price] </p>
                                            <a class='btn btn-primary' href='bookDetail.php?sell_id=$row[sell_id]'> VIEW </a>
                                        </div>
                                        
                                    </div>

                                </div>
                                ";
  
                            }

/*****************************************for Previous page*********************************************************** */
                            echo"
                                <nav aria-label='Page navigation example'>
                                <ul class='pagination'>
                            ";
                      
                            if($pages_pre < 1){
                                echo"
                                <li class='page-item'>
                                    <a class='page-link' aria-label='Previous'>
                                        <span aria-hidden='true'>&laquo;</span>
                                    </a>
                                </li>
        
                                ";
                            } else{
                                echo"
                                <li class='page-item'>
                                    <a class='page-link' href='bookBuy.php?pages=$pages_pre' aria-label='Previous'>
                                        <span aria-hidden='true'>&laquo;</span>
                                    </a>
                                </li>
        
                                ";
                                }
/*****************************************for current and all  pages*********************************************************** */
        
                            for($i = 1; $i <= $total_page; $i++){
    
                                if($i == $pages){
    
                                    echo "
                                    <li class='page-item'>
                                        <a class='page-link active'>$i</a>
                                    </li>
                                    ";
                            
                                } else{
    
                                    echo "               
                                    <li class='page-item'>
                                        <a class='page-link' href='bookBuy.php?pages=$i'>$i</a>
                                    </li>
                                    ";
                            
                                }
            
                            }
        
/*****************************************for next page*********************************************************** */

                                if($pages_next > $total_page){
                                    echo"
                                    <li class='page-item'>
                                        <a class='page-link' aria-label='Next'>
                                            <span aria-hidden='true'>&raquo;</span>
                                        </a>
                                    </li>
        
        
                                    ";
                                } else{
                                    echo"
                                    <li class='page-item'>
                                        <a class='page-link' href='bookBuy.php?pages=$pages_next' aria-label='Next'>
                                            <span aria-hidden='true'>&raquo;</span>
                                        </a>
                                    </li>
        
                                    ";
                                }

                                echo"
                                    </ul>
                                </nav>
                                ";
                            
                    } else {

                        echo "
                            <div>
                                <h1>Nothing found..!</h1>
                            </div>

                        ";
                    }
                

                ?>

                    </ul>
                </nav>

            </div>

        </div>

    </section>

</div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>