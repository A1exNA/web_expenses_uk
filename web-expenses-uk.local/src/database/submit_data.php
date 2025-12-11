<?php

require_once 'connect.php';

$formData = $_POST;

if (empty($formData)) {
    echo json_encode(['status' => 'error', 'message' => 'Данные не получены']);
    exit;
}

$objects = mysqli_query($connect, "SELECT id FROM `objects`");
$objects = mysqli_fetch_all($objects, MYSQLI_ASSOC);
$ids = array_column($objects,"id");

if ($formData['id'] == '') {
    echo json_encode(['status' => 'error', 'message' => 'Пустое поле id']);
    exit;
} else if (in_array($formData['id'], $ids)) {
    echo json_encode(['status' => 'error', 'message' => 'Такое поле id уже есть']);
    exit;
}

mysqli_query($connect, "INSERT INTO `objects` (`id`, `object_address`, `object_area`, `management_fee`, `current_repair_rate`) VALUES ('".$formData['id']."', '".$formData['object_address']."', '".$formData['object_area']."', '".$formData['management_fee']."', '".$formData['current_repair_rate']."');");

echo json_encode(['status' => 'success', 'message'=> 'Данные отправленны', 'submittedData' => $formData]);

?>