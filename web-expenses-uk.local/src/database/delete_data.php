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
} else if (!in_array($formData['id'], $ids)) {
    echo json_encode(["status" => "error", "message" => "Такого поля id нет"]);
    exit;
}

$stmt = mysqli_prepare($connect, "DELETE FROM `objects` WHERE id = ?;");

if ($stmt === false) {
    echo json_encode(["status" => "error", "message" => "Ошибка подготовки запроса: " . mysqli_error($connect)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $formData["id"]);

$success = mysqli_stmt_execute($stmt);

if ($success) {
    echo json_encode(["status" => "success", "message" => "Объект удален", "submittedData" => $formData]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Ошибка выполнения запроса: ' . mysqli_stmt_error($stmt)]);
}

mysqli_stmt_close($stmt);