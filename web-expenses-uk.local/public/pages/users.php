<?php
$title = 'Главная';
$db_name = '"users"';
require_once '../../src/templates/header.php';
?>

<a href="index.php">Главная</a>
<a href="objects.php">Объекты</a>

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
            <th>id</th>
            <th>Имя</th>
            <th>Должность</th>
            <th>email</th>
            <th>Пароль</th>
        </tr>
    </table>
</div>

<?php
require_once '../../src/templates/footer.php';
?>