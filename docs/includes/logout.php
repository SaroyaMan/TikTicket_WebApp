<?php
session_start();
$_SESSION['user_id'] = -1;  //Is Used To Destroy Specified Session
header("location: ../login.html");