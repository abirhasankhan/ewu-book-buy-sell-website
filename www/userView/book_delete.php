<?php

require '../server/config.php';

session_start();


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('location: login.php');
    exit;
}

$s_id = $_SESSION['student_id'];

 
if ( $_SERVER['REQUEST_METHOD'] == 'GET') {

    //get method: show the data of student

    if( !isset($_GET["sell_id"]) || !isset($_GET['student_id']) ){

        header('location:home.php');
        exit;
    }

    $sell_id = $_GET["sell_id"];
    $student_id = $_GET["student_id"];

    if($student_id != $s_id){
        header('location:home.php');
        exit;
    }

    $sql = "DELETE FROM `booksell` WHERE `sell_id`='$sell_id' AND `student_id`='$s_id'";
    $result = $conn->query($sql);

}

header('location:bookBuy.php');
exit;

?>