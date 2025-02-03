<?php
$servername = "localhost";
$username = "root";
$password = "NoorHaider5492";
$dbname = "Shop"; // Your database name is "Shop"

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "";
}
?>

