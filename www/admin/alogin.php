<?php

session_start();

//database connection
require '../server/config.php';

// get all value 
if (isset($_POST['alogin'])) {

    $admin = $_POST['admin'];
    $pass = $_POST['pass'];


    // checking value field is emplty or not
    if (!empty($admin)  && !empty($pass) ) {


        $sql = "SELECT * FROM admin WHERE `id` = '$admin' AND `pass` = '$pass' AND `role` = '1'";
        $query = $conn->query($sql);
        
        //if account has been activated
        if($query->num_rows > 0){

            $result_fetch = mysqli_fetch_assoc($query);

            $_SESSION['login'] = true;
            $_SESSION['id'] = $result_fetch['id'];
            $_SESSION['role'] = $result_fetch['role'];
            header('location:ahome.php');
    
        }
        // For password error
        else{
            echo "
                <script>
                    alert('Password Error');
                    window.location.href='alogin.php';
                </script>
                ";
        }
    
    } else{
        echo "
            <script>
                alert('Cannot Run Query');
                window.location.href='alogin.php';
            </script>
            ";
        }

    }
?>


<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8">
    <title>Admin Login Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body style="background-color:powderblue;">
    <div class="container">

    <h1 style="margin-top:50px; text-align:center">East West University</h5>


        <div class="row">

            <div class="col-4">

            </div>

            <div class="col-4" style="margin-top:200px">

            <?php

            if(isset($_GET['accountCreated'])){
                //echo 'Your account has been account created';
            }

            ?>


                <form action="alogin.php" method="POST">
                    <div class="mt-2">
                        <label lass="form-label"><b>Admin ID</b></label>
                        <input type="text" class="form-control" name="admin" required> 
                    </div>

                    <div class="mt-2">
                        <label lass="form-label"><b>Password</b></label>
                        <input type="password" class="form-control" name="pass" required> 
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-success" name="alogin">Log in</button>
                    </div>

                </form>
            
            </div>
          
        </div>   

    </div>


    
</body>

</html>