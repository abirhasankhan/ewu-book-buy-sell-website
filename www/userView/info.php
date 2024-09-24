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
    $toasts = "";
    if (isset($_POST['info'])) {

        $sub = $_POST['sub'];
        $text = $_POST['text'];
        $link = $_POST['report_link'];

        
        /************************************************/


        // Escape the values to prevent syntax errors
        $sub = mysqli_real_escape_string($conn, $sub);
        $text = mysqli_real_escape_string($conn, $text);
        $link = mysqli_real_escape_string($conn, $link);

        $report = "INSERT INTO `support`(`std_id`, `subject`, `detail`, `link`) VALUES ('$s_id','$sub','$text','$link')";

        $query_report = $conn->query($report);

        if($query_report){

            echo "
            <script>
                alert('Report has been sent');
                window.location.href='info.php';
            </script>
            ";


        } else{

            // for Query error
            echo "
                <script>
                    alert('Cannot Run Query');
                    window.location.href='home.php';
                </script>
                ";
        }

    }

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home</title>
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
                            <a class="nav-link active" aria-current="page" href="home.php">Home</a>
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

<div style="padding-bottom:100px">

    <div style="margin-left: 10%; margin-top: 50px;">
        <h3>You can visit our other website</h3>
        <b><a style="color:#68B7B3; text-decoration: none;" target="_blank" href="https://www.ewubd.edu/"> East West University</a></b>
        <br>
        <b><a style="color:#68B7B3; text-decoration: none;" target="_blank" href="https://portal.ewubd.edu/"> University Protal</a></b>
    </div>
   

    <div style="margin-left: 10%; margin-right: 10%; margin-top: 50px;">
        <h3>Support Section</h3>
        <p>If you need any help you can ask here. And if you want to report about the book section or request section, submit the link in the link form. We will contact you by mail.</p>

        <form action="info.php" method="POST">
            
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Subject</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Subject" name="sub" required>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Text</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text" required></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Link</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Report Link" name="report_link">
            </div>

            <br>
            
            <div class="mb-3">
                <button type="submit" class="btn btn-outline-success" id="info" name="info">SEND</button>
            </div>
   
        </form>

    </div>

</div>








    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>