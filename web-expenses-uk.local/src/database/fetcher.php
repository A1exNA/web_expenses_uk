<?php 

require_once 'server.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$action = $data['action'];
$db_name = $data['dbName'];
$ru_headers = $data['ruHeaders'];

$data_s = dbData($connect, $db_name);
$headers = $data_s['headers'];
$database = $data_s['database'];


$innerHTML = "";


if ($db_name == "expens") {
} else {
    if ($action === 'Create') {
        foreach ($headers as $index => $header) {
            $header_name = $header->name;
            $ru_header_name = $ru_headers[$index];

            if ($header_name == 'id') {
                $value = count($database) + 1;
            } else if ($header_name == 'object_address') {
                $value = "г. Тверь, ул/пер.";
            } else {
                $value = '';
            };

            $innerHTML .= <<< HTML
            <div class='input__block'>
                <div class='block__element'>$ru_header_name</div>
                <div class='block__element'><input class='font__input' id='$header_name' type='text' name='$header_name' value='$value' placeholder='Введите $ru_header_name' autocomplete='off'></div>
            </div>
            HTML;
        };
        $innerHTML .= <<< HTML
            <div class='input__block'>
                <button class='font__input' type='submit'>Отправить данные</button>
            </div>
            HTML;

        echo json_encode([
            "status" => "success",
            "headers" => $headers,
            "database" => $database,
            "innerHTML" => $innerHTML
        ]);
    } else if ($action === 'Change') {
        $innerHTML .= <<< HTML
            <div class="input__block">
                <div class="block__element">id</div>
                <div class="block__element">
                    <input class="font__input" id="input" list="id_deleted" type="text" name="id" placeholder="Введите id" autocomplete="off">
                    <datalist id="id_deleted">
        HTML;

        foreach ($database as $dataB) {
            $id_data = $dataB['id'];
            $name_data = $dataB[$headers[1]->name];
            $innerHTML .= <<< HTML
                    <option value='$id_data'>$name_data
            HTML;
        }

        $innerHTML .= <<< HTML
                </datalist>
            </div>
        </div>
        HTML;

        foreach ($headers as $index => $header) {
            $header_name = $header->name;
            $ru_header_name = $ru_headers[$index];

            if ($header_name == 'id') {
                continue;
            };

            $innerHTML .= <<< HTML
            <div class='input__block'>
                <div class='block__element'>$ru_header_name</div>
                <div class='block__element'><input class='font__input' id='$header_name' type='text' name='$header_name' value='' placeholder='Введите $ru_header_name' autocomplete='off'></div>
            </div>
            HTML;
        };
        $innerHTML .= <<< HTML
            <div class="input__block">
                <button class="font__input" type="submit">Изменить данные</button>
            </div>
        HTML;

        echo json_encode([
            "status" => "success",
            "headers" => $headers,
            "database" => $database,
            "innerHTML" => $innerHTML
        ]);
    } else if ($action === 'Delete') {
        $innerHTML .= <<< HTML
            <div class="input__block">
                <div class="block__element">id</div>
                <div class="block__element">
                    <input class="font__input" id="input" list="id_deleted" type="text" name="id" placeholder="Введите id" autocomplete="off">
                    <datalist id="id_deleted">
        HTML;

        foreach ($database as $dataB) {
            $id_data = $dataB['id'];
            $name_data = $dataB[$headers[1]->name];
            $innerHTML .= <<< HTML
                    <option value='$id_data'>$name_data
            HTML;
        }

        $innerHTML .= <<< HTML
                </datalist>
            </div>
        </div>
        HTML;

        $innerHTML .= <<< HTML
            <div class="input__block">
                <button class="font__input" type="submit">Удалить данные</button>
            </div>
        HTML;

        echo json_encode([
            "status" => "success",
            "headers" => $headers,
            "database" => $database,
            "innerHTML" => $innerHTML
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Все Плохо",
            "action" => $action,
            "headers" => $headers,
            "database" => $database,
            "ruHeaders" => $ru_headers,
            "innerHTML" => $innerHTML
        ]);
    }
}

?>