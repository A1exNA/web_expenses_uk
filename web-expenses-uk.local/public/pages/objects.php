<?php
$title = 'Объекты';
require_once '../../src/templates/header.php';
?>

<a href="index.php">Главная</a>

<?php
$objects = mysqli_query($connect, "SELECT * FROM `objects`");
$headers = mysqli_fetch_fields($objects);
$objects = mysqli_fetch_all($objects);

$objects_json_string = json_encode($objects);
$headers_json_string = json_encode($headers);
?>

<script>
    const allObjects = <?php echo $objects_json_string; ?>;
    const allHeaders = <?php echo $headers_json_string; ?>;
</script>

<?php
echo <<<HTML
<div class="window">
    <div class="window__navigate">
        <a class="navigate__button" onclick="clickNavBtn('Create', allObjects, allHeaders)">Добавить</a>
        <a class="navigate__button" onclick="clickNavBtn('Change', allObjects, allHeaders)">Изменить</a>
        <a class="navigate__button" onclick="clickNavBtn('Delete', allObjects, allHeaders)">Удалить</a>
        <a class="navigate__button" onclick="clickNavBtn('Close', allObjects, allHeaders)">Закрыть</a>
    </div>
    <form class="window__input" id="window__input">
    </form>
</div>
HTML;
?>

<div class="table">
    <table>
        <tr>
            <th>id</th>
            <th>Адрес</th>
            <th>Площадь</th>
            <th>Тариф УК</th>
            <th>Тариф Текущего Ремонта</th>
            <th>Дата начала обслуживания</th>
        </tr>

        <?php
        foreach ($objects as $object) {
            echo <<<HTML
            <tr>
                <td class="database__number">$object[0]</td>
                <td>$object[1]</td>
                <td class="database__number">$object[2] м²</td>
                <td class="database__number">$object[3] ₽</td>
                <td class="database__number">$object[4] ₽</td>
                <td class="database__number">$object[5]</td>
            </tr>
            HTML;
        }
        ?>
    </table>
</div>

<?php
require_once '../../src/templates/footer.php';
?>