<?php

require '../server/config.php';

session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] == true) {

    if ( isset($_GET["req_id"]) ) {
        $req_id = $_GET["req_id"];
    
        $sql = "DELETE FROM `req_book` WHERE req_id = '$req_id'";
        $result = $conn->query($sql);
    }
    
    header('location:my_req.php');
    exit;

        
} else {
    header('location:login.php');
} 
?>
