<?php
error_reporting(0);
session_start();
date_default_timezone_set("Asia/Manila");
$dbhost = "localhost";
$dbname = "student_management";
$dbuser = "root";
$dbpass = "";

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
