<?php
include('db_connection.php');

if(isset($_POST['mail'])) {
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $full_name = $_POST['fullName'];

    $query= "SELECT * FROM tbl_221_users WHERE mail='$mail'";
    $result = mysqli_query($connection, $query);
    if($result->num_rows == 1) {
        header("verify: -1");
    }
    else {
        $query= "INSERT INTO tbl_221_users(mail, password, full_name) VALUES('$mail', '$password', '$full_name')";
        $result = mysqli_query($connection, $query);
        header("verify: 0");
    }
}