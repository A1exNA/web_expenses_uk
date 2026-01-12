<?php
$title = 'Траты';
$db_name = '"expens"';
require_once '../../src/templates/header.php';
?>

<a href="index.php">Главная</a>
<a href="objects.php">Объекты</a>
<a href="users.php">Пользователи</a>

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
            <th colspan="3">Название</th>
            <th>Итог</th>
        </tr>
        <tr>
            <th>id</th>
            <th>Текст</th>
            <th>Цена</th>
            <th>Кол.</th>
            <th>Пользователь</th>
            <th>Дата</th>
        </tr>
    </table>
</div>

<?php
require_once '../../src/templates/footer.php';
?>