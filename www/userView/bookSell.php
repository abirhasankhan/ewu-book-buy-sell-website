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



    if (isset($_POST['bookSell'])) {

        $book_name = $_POST['book_name'];
        $writer_name = $_POST['writer_name'];
        $book_over = $_POST['book_over'];
        $lan = $_POST['lan'];
        $con = $_POST['con'];
        $price = $_POST['price'];
        $pick_loc = $_POST['pick_loc'];

        
        /************************************************/

        $r_code = bin2hex(random_bytes(8));

        $bookCover = $_FILES['bookCover']['name'];
        $tempBookCover = $_FILES['bookCover']['tmp_name'];
        $imgType =  $_FILES['bookCover']['type'];

        $filename = $r_code . $bookCover;

        $uploadPath = '../images/'. $filename;


       if($imgType == 'image/png' or $imgType == 'image/jpeg'){

        if(file_exists($uploadPath)){

            echo "Please change the book cover name and try again!";

        } else{

            if (move_uploaded_file($tempBookCover,$uploadPath)){

                // Escape the values to prevent syntax errors
                $book_name = mysqli_real_escape_string($conn, $book_name);
                $writer_name = mysqli_real_escape_string($conn, $writer_name);
                $book_over = mysqli_real_escape_string($conn, $book_over);
                $lan = mysqli_real_escape_string($conn, $lan);
                $con = mysqli_real_escape_string($conn, $con);
                $price = mysqli_real_escape_string($conn, $price);
                $pick_loc = mysqli_real_escape_string($conn, $pick_loc);
                $uploadPath = mysqli_real_escape_string($conn, $uploadPath);
                $s_id = mysqli_real_escape_string($conn, $s_id); 


                $upload = "INSERT INTO `booksell`(`book_name`, `writer_name`, `book_overview`, `language`, `book_con`, `price`, `pick_loc`, `book_img`, `student_id`, `status`) VALUES ('$book_name','$writer_name','$book_over','$lan','$con','$price', '$pick_loc','$uploadPath','$s_id', '1')";

                $query_upload = $conn->query($upload);

                if($query_upload){

                    header('location:uploadinfo.php');

                } else{

                    // for Query error
                    echo "
                        <script>
                            alert('Cannot Run Query');
                            window.location.href='signup.php';
                        </script>
                        ";
                }

               } else{

                echo "not uploaded";

               }
            
        }

       } else{

        echo "Please upload PNG type image";

       }
     
    }


?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Book Sell</title>
<link rel="stylesheet" href="../css/main.css?v=<?=$version?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/d4c3426ce2.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

</head>

<body style="background-color: #f2f6ff; background: black;">

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
                        <a class="nav-link active" href="bookSell.php">Book Sell</a>
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



<section style="font-size:20px; margin-left:70px; margin-right: 70px; background-position: center;
    background-size: cover;
    background-color: #E4E9F7;
    height: 100%;">


<div style="padding: 40px;">


    <form class="was-validated" action="bookSell.php" method="POST" enctype="multipart/form-data">

        <div class="wrapper">

            <div style="color: red;">
                <h6>  
                *update your status information after your book is sold
                </h6>      
            </div>

            <div class="title">
            Your Sell Post
            </div>

            <div class="form">

                <div class="inputfield">
                    <label for="validationCustom03" class="form-label">Book name</label>
                    <input type="text" class="form-control input" id="validationCustom03" name="book_name" required>
                </div> 

                <div class="inputfield">
                    <label for="validationCustom03" class="form-label">Writer Name</label>
                    <input type="text" class="form-control input" id="validationCustom03" name="writer_name" required>
                </div>  

                <div class="inputfield">
                    <label for="validationTextarea" class="form-label">Book Overview</label>
                    <textarea class="form-control is-invalid textarea" id="validationTextarea" name="book_over" required></textarea>
                </div> 

                <div class="inputfield">
                    <label for="validationCustom03" class="form-label">Language</label>
                    <input type="text" class="form-control input" id="validationCustom03" name="lan" required>
                </div>  
                
                <div class="inputfield">
                    <label for="validationCustom03" class="form-label">Condition</label>
                    <select class="form-select custom_select" required aria-label="select example" name="con">
                        <option value="" disabled selected>Condition</option>
                        <option value="brand new">Brand New</option>
                        <option value="used">Used</option>
                    </select>
                </div> 

                <div class="inputfield">
                    <label for="validationCustom03" class="form-label">Book Price</label>
                    <input type="text" class="form-control input" id="validationCustom03" name="price" required>
                </div> 

                <div class="inputfield">
                    <label for="validationCustom03" class="form-label">Pick Up Location</label>
                    <input type="text" class="form-control input" id="validationCustom03" name="pick_loc" required>
                </div> 
                
                <div class="inputfield">
                        <label for="validationCustom03" class="form-label">Book Cover Image</label>
                        <input type="file" class="form-control" aria-label="file example" name="bookCover" required>
                </div> 

                <div class="inputfield">
                    <input type="submit" value="Submit" class="btn" name="bookSell">
                </div>

            </div>

        </div>

    </form>

</div>


</section>






    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>