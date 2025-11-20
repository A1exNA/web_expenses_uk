<?php
$title = 'Добавить дом';
require_once '../../src/templates/header.php';
?>

        <div class="inputBlock">
            <div class="inputLine">
                <span class="inputText">id</span>
                <input class="input font__input" type="text" name="id">
            </div>
            <div class="inputLine">
                <span class="inputText">Адрес</span>
                <input class="input font__input" type="text" name="object_address">
            </div>
            <div class="inputLine">
                <span class="inputText">Площадь</span>
                <input class="input font__input" type="text" name="object_area">
            </div>
            <div class="inputLine">
                <span class="inputText">Тариф Обслуживания</span>
                <input class="input font__input" type="text" name="management_fee">
            </div>
            <div class="inputLine">
                <span class="inputText">Тариф Текущего Ремонта</span>
                <input class="input font__input" type="text" name="current_repair_rate">
            </div>
            <div class="inputLine">
                <input class="button font__input" type="submit" value="Подтвердить" onclick="submitForm()">
            </div>
        </div>

<?php
require_once '../../src/templates/footer.php';
?>