<?php
include('db_connection.php');

if(isset($_POST['notes'])) {
    //parsing the variables...
    $ticket_name = mysqli_real_escape_string($connection, $_POST['name']);
    $ticket_city = mysqli_real_escape_string($connection, $_POST['city']);
    $ticket_price = mysqli_real_escape_string($connection, $_POST['price']);
    $ticket_category = mysqli_real_escape_string($connection, $_POST['category']);
    $ticket_notes = mysqli_real_escape_string($connection, $_POST['notes']);
    session_start();
    $posted_by = $_SESSION['user_id'];
    $posted_date = date("Y-m-d");
    $queryIns = "INSERT INTO tbl_221_tickets(name, city, price, category, notes, posted_by, posted_date) 
    VALUES('$ticket_name', '$ticket_city', $ticket_price, '$ticket_category', '$ticket_notes', $posted_by, '$posted_date')";
    $result = mysqli_query($connection, $queryIns);
    $ticket_id = mysqli_insert_id($connection);

    if($ticket_category == "hotels") {
        $ticket_date = mysqli_real_escape_string($connection, $_POST['date']);
        $ticket_nights = mysqli_real_escape_string($connection, $_POST['nights']);
        insert_into_hotels($connection, $ticket_id,$ticket_date, $ticket_nights);
    }
    else if($ticket_category == "shows" || $ticket_category == "cinema") {
        $ticket_date = mysqli_real_escape_string($connection, $_POST['date']);
        insert_into_shows($connection, $ticket_id, $ticket_date);
    }
    else {
        $ticket_type = mysqli_real_escape_string($connection, $_POST['type']);
        $ticket_info = mysqli_real_escape_string($connection, $_POST['info']);
        insert_into_parks($connection, $ticket_id, $ticket_type, $ticket_info);
    }
}

function insert_into_hotels($connection, $id, $date, $num_nights) {         //category = hotels

    $queryIns = "INSERT INTO tbl_221_hotels(id, date, nights) VALUES($id, '$date', $num_nights)";
    $result = mysqli_query($connection, $queryIns);
}

function insert_into_shows($connection, $id, $date) { //category = cinema or shows
    $queryIns = "INSERT INTO tbl_221_shows(id, date) VALUES($id, '$date')";
    $result = mysqli_query($connection, $queryIns);
}

function insert_into_parks($connection, $id, $type, $info) {  //category = workshops or parks
    $queryIns = "INSERT INTO tbl_221_parks(id, type, info) VALUES($id, '$type', '$info')";
    $result = mysqli_query($connection, $queryIns);
}