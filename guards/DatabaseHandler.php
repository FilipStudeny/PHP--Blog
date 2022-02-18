<?php

//DATABASE CONNECTION SETUP

//XAMP - MySQL SETTINGS
$serverName = "localhost";
$databaseUserName = "root";
$databasePassword = "";
$databaseName = "blogdatabase";

//MySQLi connection
$connection = mysqli_connect($serverName, $databaseUserName, $databasePassword, $databaseName);

//ERROR CHECK
if(!$connection){
    die("Connection to DB failed: " . mysqli_connect_error());
}

?>