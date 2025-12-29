<?php

require_once 'connect.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (empty($data)) {
    echo json_encode(["status" => "error", "message" => "Имя таблицы не указано", "data" => $data]);
    exit;
} else if ($data['action'] == "Create") {
    createData($data, $connect, $types_list);
} else if ($data['action'] == "Change") {
    changeData($data, $connect, $types_list);
} else if ($data['action'] == "Delete") {
    deleteData($data, $connect, $types_list);
}

function createData($data, $connect, $types_list) {
    $sql = "INSERT INTO " . $data['dbName'] . " (";

    foreach ($data['database']['headers'] as $header) {
        $sql .= "`" . $header['name'] . "`, ";
    }
    $sql = substr($sql,0,-2);
    $sql .= ") VALUES (";

    foreach ($data['database']['headers'] as $header) {
        $sql .= '?' . ', ';
    }
    $sql = substr($sql,0,-2);
    $sql .= ");";

    $stmt = mysqli_prepare($connect, $sql);

    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Ошибка подготовки запроса: " . mysqli_error($connect)]);
        exit;
    }

    $types = '';
    $all_data = [];
    foreach ($data['database']['headers'] as $header) {
        if (in_array($header['name'], $types_list['integer'])) {
            $data['data'][$header['name']] = str_replace(",",".", $data['data'][$header['name']]);
            $types .= 'i';
        } else if (in_array($header['name'], $types_list['double'])) {
            $data['data'][$header['name']] = str_replace(",",".", $data['data'][$header['name']]);
            $types .= 'd';
        } else {
            $types .= 's';
        }
        if ($data['data'][$header['name']] == '') {
            $all_data[] = null;
        }
        else {
            $all_data[] = $data['data'][$header['name']];
        }
    }

    mysqli_stmt_bind_param($stmt, $types, ...$all_data);

    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        echo json_encode(["status" => "success", "data" => $data, "sql" => $sql, "types"=> $types, "all_data"=> $all_data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка выполнения запроса: ' . mysqli_stmt_error($stmt)]);
    }

    mysqli_stmt_close($stmt);
}

function changeData($data, $connect, $types_list) {
    if ($data['data']['id'] == '') {
        echo json_encode(["status" => "error", "message" => "Пустое поле id"]);
        exit;
    }

    $sql = "UPDATE " . $data['dbName'] . " SET ";

    foreach ($data['database']['headers'] as $header) {
        if ($header['name'] != "id") {
            $sql .= $header['name'] . " = ?, ";
        }
    }
    $sql = substr($sql,0,-2);
    $sql .= " WHERE id = " . $data['data']['id'] . ";";

    $stmt = mysqli_prepare($connect, $sql);

    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Ошибка подготовки запроса: " . mysqli_error($connect)]);
        exit;
    }

    $types = '';
    $all_data = [];
    foreach ($data['database']['headers'] as $header) {
        if ($header['name'] != "id") {
            if (in_array($header['name'], $types_list['integer'])) {
                $data['data'][$header['name']] = str_replace(",",".", $data['data'][$header['name']]);
                $types .= 'i';
            } else if (in_array($header['name'], $types_list['double'])) {
                $data['data'][$header['name']] = str_replace(",",".", $data['data'][$header['name']]);
                $types .= 'd';
            } else {
                $types .= 's';
            }
            if ($data['data'][$header['name']] == '') {
                $all_data[] = null;
            } else {
                $all_data[] = $data['data'][$header['name']];
            }
        }
    }

    mysqli_stmt_bind_param($stmt, $types, ...$all_data);

    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        echo json_encode(["status" => "success", "data" => $data, "sql" => $sql, "types"=> $types, "all_data"=> $all_data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка выполнения запроса: ' . mysqli_stmt_error($stmt)]);
    }

    mysqli_stmt_close($stmt);
}

function deleteData($data, $connect, $types_list) {
    $sql = "DELETE FROM " . $data['dbName'] . " WHERE id = ?;";

    $stmt = mysqli_prepare($connect, $sql);

    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Ошибка подготовки запроса: " . mysqli_error($connect)]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $data['data']['id']);

    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        echo json_encode(["status" => "success", "message" => "Объект удален", "data" => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка выполнения запроса: ' . mysqli_stmt_error($stmt)]);
    }
}

//echo json_encode(["status" => "success", "data" => $data]);

?>