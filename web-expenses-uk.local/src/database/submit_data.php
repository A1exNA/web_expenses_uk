<?php

require_once 'connect.php';

$formData = $_POST;

if (empty($formData)) {
    echo json_encode(["status" => "error", "message" => "Данные не получены"]);
    exit;
}

$objects = mysqli_query($connect, "SELECT id FROM `objects`");
$objects = mysqli_fetch_all($objects, MYSQLI_ASSOC);
$ids = array_column($objects,"id");

if ($formData['id'] == '') {
    echo json_encode(["status" => "error", "message" => "Пустое поле id"]);
    exit;
} else if (in_array($formData['id'], $ids)) {
    echo json_encode(["status" => "error", "message" => "Такое поле id уже есть"]);
    exit;
}

$stmt = mysqli_prepare($connect, "INSERT INTO `objects` 
    (`id`, `object_address`, `object_area`, `management_fee`, `current_repair_rate`) 
    VALUES (?, ?, ?, ?, ?);");

if ($stmt === false) {
    echo json_encode(["status" => "error", "message" => "Ошибка подготовки запроса: " . mysqli_error($connect)]);
    exit;
}


$formData["object_area"] = str_replace(",",".", $formData["object_area"]);
$formData["management_fee"] = str_replace(",",".", $formData["management_fee"]);
$formData["current_repair_rate"] = str_replace(",",".", $formData["current_repair_rate"]);

// Типы данных указываются одной строкой: 
// 'i' -> integer (целое число для id)
// 's' -> string (строка для адреса)
// 'd' -> double (число с плавающей точкой для площади, тарифов)
$allFormData = [
    $formData["id"],
    $formData["object_address"],
    $formData["object_area"],
    $formData["management_fee"],
    $formData["current_repair_rate"]
];
mysqli_stmt_bind_param($stmt, "isddd", ...$allFormData);

$success = mysqli_stmt_execute($stmt);

if ($success) {
    echo json_encode(["status" => "success", "message" => "Данные отправленны", "submittedData" => $formData]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Ошибка выполнения запроса: ' . mysqli_stmt_error($stmt)]);
}

mysqli_stmt_close($stmt);

?>