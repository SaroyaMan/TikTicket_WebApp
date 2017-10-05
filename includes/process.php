<?php
include('db_connection.php');

if(isset($_POST['mail'])) {
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    $query= "SELECT * FROM tbl_221_users WHERE mail='$mail' and password='$password'";
    $result = mysqli_query($connection, $query);
    if($result->num_rows == 0) {
        header("verify: -1");
    }
    else {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];
        header("verify: " . $user_id);
        session_start();
        $_SESSION['user_id'] = $user_id;
    }
}