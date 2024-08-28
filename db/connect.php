<?php
// Database configuration
$servername = "localhost"; // Database server (usually localhost)
$port = 3306; // Database port
$username = "root"; // Database username
$password = "1234"; // Database password
$dbname = "db_smom"; // Database name

// Create connection
$koneksi = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (!$koneksi) { // Check if the connection failed
    die("Connection failed: " . mysqli_connect_error());
}

date_default_timezone_set('Asia/Jakarta');
