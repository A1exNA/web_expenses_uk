<?php

$connect = mysqli_connect("MySQL-8.4", "root", "", "expenses_uk");

if (!$connect) {
    die('Error connect to database');
}

$types_list = [
    'integer' => ['id', 'check_id'],
    'double' => ['object_area', 'management_fee', 'current_repair_rate', 'price', 'quantity']
]

?>