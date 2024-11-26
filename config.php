<?php

$db_user = "project";
$db_host = "localhost";
$db_pass = "ProjectPass@2024";
$db_name = "projectdb";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
