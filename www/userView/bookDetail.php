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
    /***********************************************************************************/


    if ( $_SERVER['REQUEST_METHOD'] == 'GET') {

        //get method: show the data of student
    
        if( !isset($_GET["sell_id"]) ){
    
            header('location:bookBuy.php');
            exit;
        }
    
        $sell_id = $_GET["sell_id"];
    
        $sql = "SELECT * FROM `booksell` WHERE `sell_id` = '$sell_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    
        if(!$row){
            header('location:bookBuy.php');
            exit;
        } else{

            $book_name = $row["book_name"];
            $writer_name = $row["writer_name"];
            $book_overview = $row["book_overview"];
            $language = $row["language"];
            $book_con = $row["book_con"];
            $price = $row["price"];
            $pick_loc = $row["pick_loc"];
            $date = $row["date"];
            $student_id = $row["student_id"];
            $book_img = $row["book_img"];
            

            $std_name = "SELECT `s_firstName`, `s_lastName`, `s_phoneNo`, `s_email` FROM `student` WHERE `student_id` = '$student_id'";
            $result_name = $conn->query($std_name );

            if($result_name ->num_rows > 0){

                $result_fetch = mysqli_fetch_assoc($result_name );
    
                $std_fName = $result_fetch['s_firstName'];
                $std_lName = $result_fetch['s_lastName'];
                $s_email = $result_fetch['s_email'];
                $s_phoneNo = $result_fetch['s_phoneNo'];
    
        
            } else{
                echo "
                <script>
                    alert('Cannot Run Query');
                    window.location.href='login.php';
                </script>
                ";

            }

        }
    
    
    } 

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Book Details</title>
<link rel="stylesheet" href="../css/detail_design.css?v=<?=$version?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/d4c3426ce2.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>

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
                        <a class="nav-link" href="bookBuy.php">Book Buy</a>
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

<section>
    <div class="container">

        <div class="box">
            <?php
                echo"

                <div class='images'>
                <div class='img-holder active'>
                    <img src='$book_img'>

                </div>
            </div>

            <div class='basic-info'>
                <h1> <b>$book_name</b></h1>
                
                <span>Written By : $writer_name</span>
                
                <span>Price: $price</span> 
                
            </div>

            <div class='description'>

                <p>$book_overview</p>
                
                    <div class='support info'>
                        <b> Uploaded By: $std_fName $std_lName</b>
                        <br>
                        <br>
                        <b>ID: $student_id</b>
                        <br>
                        <br>
                        <b>Book Condition: $book_con</b>
                        <br>
                        <br>
                        <b>Upload Date: $date</b>
                        <br>
                        <br>
                        <b>Language: $language</b>
                        <br>
                        <br>
                        <b>Pick Up Location: $pick_loc</b>
                    </div>
                    
                    
                    <button id='btn' style= 'font-family: Poppins , sans-serif;
                        font-size: 15px;  
                        background: #11101D; 
                        width: 150px;  
                        text-align: flex;
                        height: 50px;
                        text-decoration: none; 
                        text-transform: uppercase; 
                        color: #E4E9F7; 
                        border-radius: 5px; 
                        cursor: pointer; 
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); '>Contact Information
                    </button>

                    <ul id='list'>
                        <li><b> Email: $s_email </b></li>
                        <li><b> Phone Number: $s_phoneNo </b></li>
                    </ul>

            </div>
            ";
            ?>



        </div>

    </div>

    <?php

        if($student_id ==  $s_id){

                
            echo"
            <div class='btn-edit'>
                <a href='bookDetailEdit.php?sell_id=$sell_id&student_id=$student_id'>
                    <i class='fa-solid fa-pen-to-square fa-2xl' style='color:#343434;'></i>
                </a>
            </div>

            ";
        }                     

    ?>


</section>








    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>
</body>
</html>