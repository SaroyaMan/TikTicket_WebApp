<?php

//create a mySQL DB connection:
$dbhost = "182.50.133.146";
$dbuser = "auxstudDB6c";
$dbpass = "auxstud6cDB1!";
$dbname = "auxstudDB6c";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//testing connection success
if(mysqli_connect_errno()) {
    die("DB connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}
mysqli_set_charset($connection, "utf8");
//mysqli_close($connection); // Closing Connection


function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

function is_expired($date) {
    $today_date = date("Y-m-d");
    return $today_date > $date ? true : false;
}