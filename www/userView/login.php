<?php
session_start();

//database connection
require '../server/config.php';

if (isset($_POST['login'])){


    $s_email = $_POST['s_email'];
    $s_password = $_POST['s_password'];

     // checking value field is emplty or not
     if (!empty($s_email)  && !empty($s_password) ){

        // convert to md5
        $md5_s_pass = md5($s_password);

        $sql = "SELECT * FROM student WHERE `s_email` = '$s_email' AND `s_password` = '$md5_s_pass' AND `is_verified` = '1'";
        $notStudent = "SELECT * FROM student WHERE `s_email` = '$s_email' AND `s_password` = '$md5_s_pass' AND `is_verified` = '0'";
        $studentError = "SELECT * FROM student WHERE `s_email` = '$s_email'";


        $query = $conn->query($sql);
        $queryNotStudent = $conn->query($notStudent);
        $queryStudentError = $conn->query($studentError);




        //if account has been activated
        if($query->num_rows > 0){

            $result_fetch = mysqli_fetch_assoc($query);

            $_SESSION['login'] = true;
            $_SESSION['student_id'] = $result_fetch['student_id'];
            $_SESSION['s_firstName'] = $result_fetch['s_firstName'];
            $_SESSION['s_lastName'] = $result_fetch['s_lastName'];
            $_SESSION['s_phoneNo'] = $result_fetch['s_phoneNo'];
            $_SESSION['s_email'] = $result_fetch['s_email'];
            $_SESSION['is_verified'] = $result_fetch['is_verified'];
            header('location:home.php');
       

    
        }

        //if account has not been activated
        elseif($queryNotStudent->num_rows > 0) {
            echo "
                <script>
                    alert('Your account has not been activated yet');
                    window.location.href='login.php';
                </script>
                ";
        }

        // Student ID not found
        elseif($queryStudentError->num_rows == 0){
            echo "
                <script>
                    alert('Email not found');
                    window.location.href='login.php';
                </script>
                ";
        }
    
        // For password error
        else{
            echo "
                <script>
                    alert('Password Error');
                    window.location.href='login.php';
                </script>
                ";
        }



    } else{
        echo "
            <script>
                alert('Cannot Run Query');
                window.location.href='login.php';
            </script>
            ";
        }

}




?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In and Sign Up Form</title>
<link rel="stylesheet" href="../css/style.css">
<script src="https://kit.fontawesome.com/d4c3426ce2.js" crossorigin="anonymous"></script>

</head>
<body>
 <div class="container">
    <div class="form-box">
        <h1 id="title" >Sign in</h1>

        <?php

            if(isset($_GET['accountCreated'])){
               // echo 'Your account has been account created';
            }

        ?>

        <form action="login.php" method="POST">

            <div class="input-group">               

                <div class="input-field">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" class="form-control" placeholder="Email" name="s_email" required>

                </div>

                <div class="input-field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="Password" class="form-control" placeholder="Password" name="s_password" required>
                </div>
                <p> Don't have an account? <a href="signup.php"> <u><b>Sign up!</b></u> </a></p>


             </div>  
             
             <div class="btn-field">
                <button type="submit" id="signinbtn" name="login">Sign in</button>
                
             </div>
        </form>
    </div>
 </div>


</body>
</html>