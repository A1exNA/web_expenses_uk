<?php

require_once 'connect.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (empty($data)) {
    echo json_encode(["status" => "error", "message" => "Имя таблицы не указано", "data" => $data]);
    exit;
}

$sql = "SELECT * FROM " . $data['dbName'];
$stmt = mysqli_prepare($connect, $sql);

if ($stmt === false) {
    echo json_encode(["status" => "error", "message" => "Ошибка подготовки запроса: " . mysqli_error($connect)]);
    exit;
};

$success = mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$db_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
$db_headers = mysqli_fetch_fields($result);

$innerHTML = '';

foreach ($db_data as $row) {
    $innerHTML .= '<tr>';
    foreach ($db_headers as $header) {
        $innerHTML .= '<td>' . htmlspecialchars($row[$header->name]) . '</td>';
    };
    $innerHTML .= '</tr>';
};

if ($success) {
    echo json_encode([
        "status" => "success", 
        "message" => "Данные получены", 
        "data" => $data, 
        "sql" => $sql, 
        "db_data" => $db_data, 
        "db_headers" => $db_headers, 
        "innerHTML" => $innerHTML
    ]);
} else {
    echo json_encode([
        'status' => 'error', 
        'message' => 'Ошибка выполнения запроса: ' . mysqli_stmt_error($stmt), 
        "data" => $data, 
        "sql" => $sql
    ]);
};

mysqli_stmt_close($stmt);