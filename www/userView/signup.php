<?php
session_start();
//database connection
require '../server/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


function sendMail($s_email,$v_code){

    $mail = new PHPMailer(true);


    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                           //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                      //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                  //Enable SMTP authentication
        $mail->Username   = 'ak00.abirkhan@gmail.com';             //SMTP username
        $mail->Password   = 'yymyoniavfnkpfez';                  //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          //Enable implicit TLS encryption
        $mail->Port       = 587;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );


    
        //Recipients
        $mail->setFrom('ak00.abirkhan@gmail.com', 'EWU');
        $mail->addAddress($s_email);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'New account confirmation from EWU';
        $mail->Body    = "This email is to confirm the account you just created at EWU book buy and sell website.
         Click the link below and finish the registration process 
         <a href='http://localhost/www/userView/verify.php?s_email=$s_email&v_code=$v_code'>Verify</a>";
    
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }


}

// get all value 
if(isset($_POST['register'])){

    $s_id = $_POST['s_id'];
    $s_fName = $_POST['s_fName'];
    $s_lName = $_POST['s_lName'];
    $s_phoneNo = $_POST['s_phoneNo'];
    $s_email = $_POST['s_email'];
    $s_password = $_POST['s_password'];
    $s_password_confirmation = $_POST['s_password_confirmation'];
    $v_code = bin2hex(random_bytes(16));


    // Escape the values to prevent syntax errors
    $s_id = mysqli_real_escape_string($conn, $s_id);
    $s_fName = mysqli_real_escape_string($conn, $s_fName);
    $s_lName = mysqli_real_escape_string($conn, $s_lName);
    $s_phoneNo = mysqli_real_escape_string($conn, $s_phoneNo);
    $s_email = mysqli_real_escape_string($conn, $s_email);
    $s_password = mysqli_real_escape_string($conn, $s_password);
    $pick_loc = mysqli_real_escape_string($conn, $pick_loc);
    $s_password_confirmation = mysqli_real_escape_string($conn, $s_password_confirmation);

    // checking value field is emplty or not
    if ( !empty($s_id) && !empty($s_fName) && !empty($s_lName) && !empty($s_phoneNo) && !empty($s_email) && !empty($s_password) && !empty($s_password_confirmation) ) {

         // Check if the email address is valid
         if (filter_var($s_email, FILTER_VALIDATE_EMAIL)) {
             // Get the domain name from the email address
             $domain = substr(strrchr($s_email, "@"), 1);
            
             // Check if the domain name is a university domain
             $university_domains = array("std.ewubd.edu");
             if (in_array($domain, $university_domains)) {
                 // The email address is from a university domain
                 // Proceed with registration
                 // ...

                 // matching password
                 if ($s_password === $s_password_confirmation){
                     // creating passwprd hash
                     $md5_s_pass = md5($s_password);

                 // checking for exist user
                 $user_exist_query = "SELECT * FROM student WHERE student_id = '$s_id' OR s_email = '$s_email' ";
                 $result = $conn->query($user_exist_query); 
                
                     if($result){

                         // it will be executed for  Student ID or Email
                         if(mysqli_num_rows($result) > 0){

                             $result_fetch = mysqli_fetch_assoc($result);

                             if($result_fetch['student_id'] == $s_id){
                                 // Error for Student ID existence
                                 echo "
                                     <script>
                                         alert('Already have an account in this Student ID.');
                                         window.location.href='signup.php';
                                     </script>
                                     ";
                             } else {        
                                 // Error for Email existence
                                 echo "
                                     <script>
                                         alert('Already have an account in this Email.');
                                         window.location.href='signup.php';
                                     </script>
                                     ";
                             }  

                         } else{

                             // If user don't exist then insert into databasae
                             $insert = "INSERT INTO student (student_id, s_firstName, s_lastName, s_phoneNo, s_email, s_password, ver_code, is_verified) VALUES ('$s_id', '$s_fName', '$s_lName', '$s_phoneNo', '$s_email', '$md5_s_pass', '$v_code', '0')";
                             $query_run = $conn->query($insert); 

                             if($query_run){

                                sendMail($s_email,$v_code);

                                 // after create a account, jump to login page
                                header('location:after_signup_page.php?accountCreated');
                             } else{

                                 // for Query error
                                 echo "
                                     <script>
                                         alert('Cannot Run Query');
                                         window.location.href='signup.php';
                                     </script>
                                     ";
                             }
                         }
                     }
                 }



             } else {
                 // The email address is not from a university domain
                 // Show an error message
                 echo "
                     <script>
                         alert('Only students with a university email address can register.');
                         window.location.href='signup.php';
                     </script>
                     ";
             }
         } else {
             // The email address is not valid
             // Show an error message
             echo "
                 <script>
                     alert('Please enter a valid email address.');
                     window.location.href='signup.php';
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
<title>Sign In and Sign Up Form</title>
<link rel="stylesheet" href="../css/style.css">
<script src="https://kit.fontawesome.com/d4c3426ce2.js" crossorigin="anonymous"></script>

</head>
<body>


 <div class="container">
    
    <div class="form-box">

        <h1 id="title" >Sign Up</h1>

        <form action="signup.php" method="POST">

            <div class="input-group1">

                <div class="input-field">
                    <i class="fa-solid fa-id-badge"></i>
                    <input type="text" class="form-control" placeholder="Student ID" name="s_id" required>

                </div>

                <div class="input-field" id="nameField">
                    <i class="fa-solid fa-user-tie"></i>
                    <input type="text" class="form-control" placeholder="First Name" name="s_fName" required>

                </div>

                <div class="input-field" id="nameField">
                    <i class="fa-solid fa-user-tie"></i>
                    <input type="text" class="form-control" placeholder="Last Name" name="s_lName" required>

                </div>

                <div class="input-field">
                    <i class="fa-solid fa-square-phone"></i>
                    <input type="Phone" class="form-control" placeholder="Phone Number" name="s_phoneNo" required>

                </div>

                <div class="input-field">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="Student Email" class="form-control" placeholder="Email" name="s_email" required>

                </div>

                <div class="input-field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="Password" class="form-control" placeholder="Password" name="s_password" required>
                </div>

                <div class="input-field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="Password" class="form-control" placeholder="Retype Password" name="s_password_confirmation" required>
                </div>

                <br>

                <p> Already have an account? <a href="login.php"> <u><b>Sign in!</b></u>  </a></p>
                <br>

                <div class="btn-field">
                    <button type="submit" id="signupbtn" name="register">Sign up</button>
                </div>

    
            </div>  

       
             
        </form>

    </div>

 </div>


</body>
</html>