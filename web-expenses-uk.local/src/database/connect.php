<?php

$connect = mysqli_connect("MySQL-8.4", "root", "", "expenses_uk");

if (!$connect) {
    die('Error connect to database');
}

?>