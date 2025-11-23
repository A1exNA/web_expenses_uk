<?php
$title = 'Объекты';
require_once '../../src/templates/header.php';
?>

<a href="index.php">Главная</a>

<div class="window">
    <div class="window__navigate">
        <a class="navigate__button">Добавить</a>
        <a class="navigate__button">Изменить</a>
        <a class="navigate__button">Удалить</a>
    </div>
</div>

<div class="table">
    <table>
        <tr>
            <th>id</th>
            <th>Адрес</th>
            <th>Площадь</th>
            <th>Тариф УК</th>
            <th>Тариф Текущего Ремонта</th>
        </tr>

        <?php
        $objects = mysqli_query($connect, "SELECT * FROM `objects`");
        $objects = mysqli_fetch_all($objects);
        foreach ($objects as $object) {
            echo <<<HTML
            <tr>
                <td>$object[0]</td>
                <td>$object[1]</td>
                <td>$object[2]</td>
                <td>$object[3]</td>
                <td>$object[4]</td>
            </tr>
        HTML;
        }
        ?>
    </table>
</div>

<?php
require_once '../../src/templates/footer.php';
?>