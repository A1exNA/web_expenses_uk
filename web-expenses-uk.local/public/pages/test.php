<?php
$title = 'Тест';
$db_name = '"test"';
require_once '../../src/templates/header.php';
?>

<a href="index.php">Главная</a>
<a href="users.php">Пользователи</a>
<a href="expens.php">Траты</a>

<?php
echo <<<HTML
<div class="window">
    <div class="window__navigate">
        <a class="navigate__button" onclick="clickNavBtn('Create', dbName)">Добавить</a>
        <a class="navigate__button" onclick="clickNavBtn('Change', dbName)">Изменить</a>
        <a class="navigate__button" onclick="clickNavBtn('Delete', dbName)">Удалить</a>
        <a class="navigate__button" onclick="clickNavBtn('Close', dbName)">Закрыть</a>
    </div>
    <form class="window__input" id="window__input">
    </form>
</div>
HTML;
?>

<div class="table">
    <table id="db_table">
        <tr>
            <th rowspan="2">id</th>
            <th colspan="2">Объект</th>
            <th colspan="2">Название</th>
            <th>Итог</th>
        </tr>
        <tr>
            <th>id</th>
            <th>Текст</th>
            <th>Цена</th>
            <th>Пользователь</th>
            <th>Дата</th>
        </tr>
        <!-- ПЕРВЫЙ БЛОК ДАННЫХ -->
        <tr>
            <td rowspan="4">1</td>
            <td colspan="2">г. Тверь, ул. Веры Бонч-Бруевич, д. 26</td>
            <td colspan="2">Ремонт крыши Тест</td>
            <td class="database__double">369.00</td>
        </tr>
        <tr>
            <td class="td__footer">1</td>
            <td class="td__footer">Крипеж</td>
            <td class="database__double td__footer">123.00</td>
            <td class="td__footer">Александр Н.</td>
            <td class="td__footer">20.11.2025</td>
        </tr>
        <tr>
            <td class="td__footer">2</td>
            <td class="td__footer">Крипеж</td>
            <td class="database__double td__footer">123.00</td>
            <td class="td__footer">Александр Н.</td>
            <td class="td__footer">20.11.2025</td>
        </tr>
        <tr>
            <td class="td__footer">3</td>
            <td class="td__footer">Крипеж</td>
            <td class="database__double td__footer">123.00</td>
            <td class="td__footer">Александр Н.</td>
            <td class="td__footer">20.11.2025</td>
        </tr>
        <!-- ПЕРВЫЙ БЛОК ДАННЫХ -->
        <tr>
            <td rowspan="4">2</td>
            <td colspan="2">г. Тверь, ул. Веры Бонч-Бруевич, д. 26</td>
            <td colspan="2">Ремонт крыши Тест</td>
            <td class="database__double">369.00</td>
        </tr>
        <tr>
            <td class="td__footer">4</td>
            <td class="td__footer">Крипеж</td>
            <td class="database__double td__footer">123.00</td>
            <td class="td__footer">Александр Н.</td>
            <td class="td__footer">20.11.2025</td>
        </tr>
        <tr>
            <td class="td__footer">5</td>
            <td class="td__footer">Крипеж</td>
            <td class="database__double td__footer">123.00</td>
            <td class="td__footer">Александр Н.</td>
            <td class="td__footer">20.11.2025</td>
        </tr>
        <tr>
            <td class="td__footer">6</td>
            <td class="td__footer">Крипеж</td>
            <td class="database__double td__footer">123.00</td>
            <td class="td__footer">Александр Н.</td>
            <td class="td__footer">20.11.2025</td>
        </tr>
        <!-- ПЕРВЫЙ БЛОК ДАННЫХ -->
        <tr>
            <td rowspan="4">3</td>
            <td colspan="2">г. Тверь, ул. Веры Бонч-Бруевич, д. 26</td>
            <td colspan="2">Ремонт крыши Тест</td>
            <td class="database__double">2223.00</td>
        </tr>
        <tr>
            <td class="td__footer">7</td>
            <td class="td__footer">Крипеж</td>
            <td class="database__double td__footer">123.00</td>
            <td class="td__footer">Александр Н.</td>
            <td class="td__footer">20.11.2025</td>
        </tr>
        <tr>
            <td class="td__footer">8</td>
            <td class="td__footer">Снегодержатели</td>
            <td class="database__double td__footer">600.00</td>
            <td class="td__footer">Александр Н.</td>
            <td class="td__footer">20.11.2025</td>
        </tr>
        <tr>
            <td class="td__footer">9</td>
            <td class="td__footer">Шифер</td>
            <td class="database__double td__footer">1500.00</td>
            <td class="td__footer">Александр Н.</td>
            <td class="td__footer">20.11.2025</td>
        </tr>
    </table>
</div>

<?php
require_once '../../src/templates/footer.php';
?>