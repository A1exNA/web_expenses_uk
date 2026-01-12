<?php

require_once 'connect.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (empty($data)) {
    echo json_encode(["status" => "error", "message" => "Имя таблицы не указано", "data" => $data]);
    exit;
} else if ($data['action'] == "loadData") {
    loadData($connect, $data['dbName'], $types_list);
}


// Функция на поиск headers и database

function dbData($connect, $db_name) {
    $sql = "SELECT * FROM " . $db_name;
    $stmt = mysqli_prepare($connect, $sql);

    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Ошибка подготовки запроса: " . mysqli_error($connect)]);
        exit;
    }

    $success = mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $database = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $headers = mysqli_fetch_fields($result);
    if ($success) {
        mysqli_stmt_close($stmt);
        return ['database' => $database, 'headers' => $headers];
    }

    mysqli_stmt_close($stmt);
}


// Поиск данных по id

function searchId($connect, $db_name, $name_row, $id) {
    $sql = "SELECT " . $name_row . " FROM " . $db_name . " WHERE id = " . $id;
    $stmt = mysqli_prepare($connect, $sql);

    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Ошибка подготовки запроса: " . mysqli_error($connect)]);
        exit;
    }

    $success = mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $result = mysqli_fetch_assoc($result);

    if ($success) {
        mysqli_stmt_close($stmt);
        return $result;
    }

    mysqli_stmt_close($stmt);
}


// Передача на страницу пользователя данных из sql

function loadData($connect, $db_name, $types_list) {
    $innerHTML = '';

    if ($db_name == 'expens') {
        $checks = dbData($connect, 'checks');
        $cheaks_data = $checks['database'];

        $expens = dbData($connect, 'expens');
        $expens_data = $expens['database'];

        foreach ($cheaks_data as $cheak) {
            $rowspan = array_count_values(array_column($expens_data, 'check_id'));
            $rowspan[$cheak['id']] = $rowspan[$cheak['id']] + 1;
            $object = searchId($connect, 'objects', 'object_address', $cheak['object_id']);

            $exp = array_filter($expens_data, fn($item) => $item['check_id'] == $cheak['id']);
            $sum = number_format(array_sum(array_column($exp, 'price')), 2,'.','');
            $exp_id = array_column($exp, 'id');
            $exp_text = array_column($exp, 'text');
            $exp_price = array_column($exp, 'price');
            $exp_quantity = array_column($exp, 'quantity');
            $exp_user_id = array_column($exp, 'user_id');
            $exp_date = array_column($exp, 'date');

            $innerHTML .= <<< HTML
        <tr>
            <td class="database__integer" rowspan="{$rowspan[$cheak['id']]}">{$cheak['id']}</td>
            <td colspan="2">{$object['object_address']}</td>
            <td colspan="3">{$cheak['text']}</td>
            <td class="database__double">{$sum}</td>
        </tr>
        HTML;

            $rowspan[$cheak['id']] = $rowspan[$cheak['id']] - 1;

            for ($i = 0; $i < $rowspan[$cheak['id']]; $i++) {
                $user_name = searchId($connect, 'users', 'user_name', $exp_user_id[$i]);
                $innerHTML .= <<< HTML
        <tr>
            <td class="database__integer td__footer">{$exp_id[$i]}</td>
            <td class="td__footer">{$exp_text[$i]}</td>
            <td class="database__double td__footer">{$exp_price[$i]}</td>
            <td class="database__double td__footer">{$exp_quantity[$i]}</td>
            <td class="td__footer">{$user_name['user_name']}</td>
            <td class="td__footer">{$exp_date[$i]}</td>
        </tr>
        HTML;
            }
        }
        echo json_encode([
            "status" => "success",
            "cheaks_data" => $cheaks_data,
            "expens_data" => $expens_data,
            "innerHTML" => $innerHTML
        ]);
    } else {
        $data = dbData($connect, $db_name);
        $headers = $data['headers'];
        $database = $data['database'];
        foreach ($database as $row) {
            $innerHTML .= '<tr>';
            foreach ($headers as $header) {
                if (in_array($header->name, $types_list['double'], true)) {
                    $innerHTML .= '<td class="database__double">' . htmlspecialchars($row[$header->name]) . '</td>';
                } else if (in_array($header->name, $types_list['integer'], true)) {
                    $innerHTML .= '<td class="database__integer">' . htmlspecialchars($row[$header->name]) . '</td>';
                } else {
                    $innerHTML .= '<td>' . htmlspecialchars($row[$header->name]) . '</td>';
                }
            };
            $innerHTML .= '</tr>';
        }
        echo json_encode([
            "status" => "success",
            "innerHTML" => $innerHTML
        ]);
    }
}