<?php
$server = "127.0.0.1";
$name = "root";
$password = "";
$dbname = "AzAnAuto";

$connect = new mysqli($server, $name, $password, $dbname);
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
