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
    
        if( !isset($_GET["req_id"]) ){ 
    
            header('location:home.php');
            exit;

        } else{


            $req_id = $_GET["req_id"];
        
            $sql = "SELECT * FROM `req_book` WHERE `req_id` = '$req_id'";

            //$result = $conn->query($sql);

            $result = mysqli_query($conn, $sql);


    /************* ************************************** */

            $req_fill = "SELECT * FROM `req_fulfill` WHERE `req_id` = '$req_id'";

            //$result_req_fill  = $conn->query($req_fill);

            $result_req_fill = mysqli_query($conn, $req_fill);

            /*************************************/
            $req_std = "SELECT `req_student_id` FROM `req_book` WHERE `req_id` = '$req_id'";

            $result_req_std = $conn->query($req_std);

            if ($result_req_std->num_rows > 0){
                $query = $result_req_std->fetch_assoc();
                $req_stdId = $query["req_student_id"];

            }
    
        }
 
    } else {
        header('location:home.php');
    }





?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Request Detail</title>
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

<section style="font-size:20px; margin-left:70px; margin-right: 70px; background-position: center;
    background-size: cover;
    background-color: #E4E9F7;
    height: 100%;">

    <h3 style="text-align:left; padding-top:40px;"><b>Request Detail</b></h3>
    <hr>

    <div class="my-4" style="padding:20px;">

        <b>

            <table class="col s12 table bordered reqshow-table" style="margin-top: 15px;">
                
                <tbody>

                    <?php
                    
                        if ($result->num_rows > 0) {
                                    
                            while($row = $result->fetch_assoc()){

                                echo"

                                    <div>
                                        <tr>
                                        <td>Book Name</td>  
                                        <td>$row[book_name]</td>
                                        </tr>

                                        <tr>
                                            <td>Writer name</td>  
                                            <td>$row[writer_name]</td>
                                        </tr>

                                        <tr>
                                            <td>Detail</td>  
                                            <td>$row[book_detail]</td>
                                        </tr>

                                        <tr>
                                            <td>Added on</td>  
                                            <td>$row[date]</td>
                                        </tr>

                                        <tr>
                                            <td>Requested by</td>  
                                            <td>$row[req_student_id]</td>
                                        </tr>
                                    </div>

                                ";

                            }
                        } else{
                            echo"

                                    <div>
                                        <tr>
                                        <td>Book Name</td>  
                                        <td></td>
                                        </tr>

                                        <tr>
                                            <td>Writer name</td>  
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td>Detail</td>  
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td>Added on</td>  
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td>Requested by</td>  
                                            <td></td>
                                        </tr>
                                    </div>

                                ";

                        }

                        if ($result_req_fill ->num_rows > 0) {
                                    
                            while($row = $result_req_fill->fetch_assoc()){

                                echo"

                                    <div>
                                        <tr>
                                            <td>Filled by</td>  
                                            <td>$row[fill_by_student_id] on $row[fill_date]</td>
                                        </tr>

                                        <tr>
                                            <td>Filled Link</td>  
                                            <td><a href='$row[link]'> view </a></td>
                                        </tr>
                                    </div>

                                ";

                            }
                        } else{

                            if($s_id === $req_stdId){
            
                                echo "

                                    <div>

                                        <tr >

                                            <td>Fill Request</td>

                                            <td>

                                                <form method='Post' action='req_fill.php'>

                                                    <div class='mt-2'>
                                                        <input type='hidden' class='form-control' placeholder='Req ID' name='req_id' value='$req_id' readonly>
                                                    </div>
                                                    <div class='mt-2'>
                                                        <input type='hidden' class='form-control' placeholder='Req Student ID' name='req_stdId' value='$req_stdId' readonly>
                                                    </div>
                                                    <div class='mt-2'>
                                                        <input type='hidden' class='form-control' placeholder='Student ID' name='std_id' value='$s_id' readonly>
                                                    </div>
                                                    
                                                    <div class='row'>

                                                        <div class='col s9 m10'>
                                                            <input type='text' class='form-control' id='validationCustom03' placeholder='Link to Book page' name='request_fill_url' required>
                                                        </div>

                                                        <div class='col s3 m2'>
                                                            <button type='submit' class='btn btn-outline-info' id='req_fill' name='req_fill'>Fill</button>
                                                        </div>
                                                    </div>
                                                    
                                                </form>

                                            </td>

                                        </tr>

                                        <tr>
                                            <td>Action</td>  
                                            <td><a class='btn btn-danger btn-ml' href='req_delete.php?req_id=$req_id'><b>Delete</b></a></td>
                                        </tr>

                                    </div>

                                    
                                ";
                            } else{
                                echo "

                                    <div>

                                        <tr >

                                            <td>Fill Request</td>

                                            <td>

                                                <form method='Post' action='req_fill.php'>

                                                    <div class='mt-2'>
                                                        <input type='hidden' class='form-control' placeholder='Req ID' name='req_id' value='$req_id' readonly>
                                                    </div>
                                                    <div class='mt-2'>
                                                        <input type='hidden' class='form-control' placeholder='Req Student ID' name='req_stdId' value='$req_stdId' readonly>
                                                    </div>
                                                    <div class='mt-2'>
                                                        <input type='hidden' class='form-control' placeholder='Student ID' name='std_id' value='$s_id' readonly>
                                                    </div>
                                                    
                                                    <div class='row'>

                                                        <div class='col s9 m10'>
                                                            <input type='text' class='form-control' id='validationCustom03' placeholder='Link to Book page' name='request_fill_url' required>
                                                        </div>

                                                        <div class='col s3 m2'>
                                                            <button type='submit' class='btn btn-outline-info' id='req_fill' name='req_fill'>Fill</button>
                                                        </div>
                                                    </div>
                                                    
                                                </form>

                                            </td>

                                        </tr>

                                    </div>

                                ";

                            }

                        }

                    ?>

                </tbody>

            </table>

        </b>

    </div>

</section>







    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>