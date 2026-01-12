<?php 

require_once 'server.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$action = $data['action'];
$db_name = $data['dbName'];
$ru_headers = $data['ruHeaders'];


$innerHTML = "";


if ($db_name == "expens") {
    $checks = dbData($connect, 'checks');
    $cheaks_data = $checks['database'];

    $expens = dbData($connect, 'expens');
    $expens_data = $expens['database'];

    if ($action === 'Create') {
    $innerHTML .= <<< HTML
        <div class='input__block'>
            <div class='block__element'>id</div>
            <div class='block__element'><input class='font__input' id='check_id' type='text' name='check_id' value='' placeholder='Введите id' autocomplete='off'></div>
        </div>
        <div class='input__block'>
            <div class='block__element'>Объект</div>
            <div class='block__element'><input class='font__input' id='check_object_id' type='text' name='check_object_id' value='' placeholder='Введите Объект' autocomplete='off'></div>
        </div>
        <div class='input__block'>
            <div class='block__element'>Название</div>
            <div class='block__element'><input class='font__input' id='check_text' type='text' name='check_text' value='' placeholder='Введите Название' autocomplete='off'></div>
        </div>
        <div class='input__block'>
            <div class='block__element' id='expens'>Товар №1</div>
            <div class='block__element'>
                <input class='font__input input__line__id' id='expens_id' type='text' name='expens_id' value='' placeholder='id' autocomplete='off'>
                <input class='font__input input__line__text' id='expens_text' type='text' name='expens_text' value='' placeholder='Название' autocomplete='off'>
                <input class='font__input input__line__price' id='expens_price' type='text' name='expens_price' value='' placeholder='Цена' autocomplete='off'>
                <input class='font__input input__line__quantity' id='expens_quantity' type='text' name='expens_quantity' value='' placeholder='Количество' autocomplete='off'>
                <input class='font__input input__line__users' id='expens_user_id' type='text' name='expens_user_id' value='' placeholder='Пользователь' autocomplete='off'>
                <input class='font__input input__line__date' id='expens_date' type='text' name='expens_date' value='' placeholder='Дата' autocomplete='off'>
            </div>
        </div>
        <div class='input__block'>
            <button class='font__input' type='submit' name='action' value='new_expens'>Добавить товар</button>
        </div>
        <div class='input__block'>
            <button class='font__input' type='submit' name='action' value='save'>Отправить данные</button>
        </div>
    HTML;

        echo json_encode([
            "status" => "success",
            "cheaksData" => $cheaks_data,
            "expensData" => $expens_data,
            "ruHeaders" => $ru_headers,
            "innerHTML" => $innerHTML
        ]);
    } else if ($action === 'Change') {

        echo json_encode([
            "status" => "success",
            "cheaksData" => $cheaks_data,
            "expensData" => $expens_data,
            "ruHeaders" => $ru_headers,
            "innerHTML" => $innerHTML
        ]);
    } else if ($action === 'Delete') {

        echo json_encode([
            "status" => "success",
            "cheaksData" => $cheaks_data,
            "expensData" => $expens_data,
            "ruHeaders" => $ru_headers,
            "innerHTML" => $innerHTML
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Все Плохо",
            "action" => $action,
            "innerHTML" => $innerHTML
        ]);
    }
} else {
    $data_s = dbData($connect, $db_name);
    $headers = $data_s['headers'];
    $database = $data_s['database'];
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
                <button class='font__input' type='submit' name='action' value='save'>Отправить данные</button>
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
                <button class='font__input' type='submit' name='action' value='save'>Изменить данные</button>
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
                <button class='font__input' type='submit' name='action' value='save'>Удалить данные</button>
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
            "innerHTML" => $innerHTML
        ]);
    }
}

?>