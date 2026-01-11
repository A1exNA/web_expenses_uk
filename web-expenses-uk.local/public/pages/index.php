<?php
$title = 'Главная';
$db_name = '"index"';
require_once '../../src/templates/header.php';
?>

<a href="objects.php">Объекты</a>
<a href="users.php">Пользователи</a>
<a href="expens.php">Траты</a>

<?php
require_once '../../src/templates/footer.php';
?>