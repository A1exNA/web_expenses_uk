<?php

require_once 'connect.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (empty($data)) {
    echo json_encode(["status" => "error", "message" => "Имя таблицы не указано", "data" => $data]);
    exit;
} else if ($data['action'] == "dbData") {
    dbData($connect, $data);
} else if ($data['action'] == "loadData") {
    loadData($data, $types_list);
}

// Функция на поиск headers и database

function dbData($connect, $data) {
    $sql = "SELECT * FROM " . $data['dbName'];
    $stmt = mysqli_prepare($connect, $sql);

    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Ошибка подготовки запроса: " . mysqli_error($connect)]);
        exit;
    };

    $success = mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $db_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $db_headers = mysqli_fetch_fields($result);if ($success) {
        echo json_encode([
            "status" => "success",
            "message" => "Данные получены",
            "data" => $data,
            "dbData" => $db_data,
            "dbHeaders" => $db_headers
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Ошибка выполнения запроса: " . mysqli_stmt_error($stmt),
            "data" => $data,
            "dbData" => $db_data,
            "dbHeaders" => $db_headers
        ]);
    };

    mysqli_stmt_close($stmt);
};

// Передача на страницу пользователя данных из sql

function loadData($data, $types_list) {
    $db_headers = $data["headers"];
    $db_database = $data["database"];

    $innerHTML = '';

    foreach ($db_database as $row) {
        $innerHTML .= '<tr>';
        foreach ($db_headers as $header) {
            if (in_array($header['name'], $types_list['double'], true)) {
                $innerHTML .= '<td class="database__number">' . htmlspecialchars($row[$header['name']]) . '</td>';
            } else {
                $innerHTML .= '<td>' . htmlspecialchars($row[$header['name']]) . '</td>';
            }
        };
        $innerHTML .= '</tr>';
    };

    
    echo json_encode([
        "status" => "success",
        "message" => "Данные получены",
        "data" => $data,
        "dbData" => $db_database,
        "dbHeaders" => $db_headers,
        "innerHTML" => $innerHTML
    ]);
};

