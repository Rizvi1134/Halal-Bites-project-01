<?php
$conn = new mysqli("localhost", "root", "", "halal_bites");

if ($conn->connect_error) {
    die("Connection Failed");
}
?>