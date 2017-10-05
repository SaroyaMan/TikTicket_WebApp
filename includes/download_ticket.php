<?php
include('db_connection.php');
if(isset($_POST['id'])) {
    //parsing the variables...
    $ticket_id = mysqli_real_escape_string($connection, $_POST['id']);
    $query_update = "SELECT is_sold FROM tbl_221_tickets WHERE id=$ticket_id ";
    $result = mysqli_query($connection, $query_update);
    $ticket_is_sold = mysqli_fetch_assoc($result);
    $ticket_is_sold = $ticket_is_sold['is_sold'];
    if($ticket_is_sold == 1) {
        echo 1;
    }
    else {
        $bought_date = date("Y-m-d");
        session_start();
        $user_id = $_SESSION['user_id'];
        $query_update = "UPDATE tbl_221_tickets SET is_sold=1, bought_date='$bought_date', bought_by=$user_id WHERE id=$ticket_id";
        $result = mysqli_query($connection, $query_update);
        $ticket_id = mysqli_insert_id($connection);
        echo 2;
    }
}