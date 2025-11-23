<?php
$title = 'Добавить дом';
require_once '../../src/templates/header.php';
?>

<form class="inputBlock">
    <div class="inputLine">
        <span class="inputText">id</span>
        <input class="input font__input" type="text" name="id" id="id" placeholder="id" autocomplete="off">
    </div>
    <div class="inputLine">
        <span class="inputText">Адрес</span>
        <input class="input font__input" type="text" name="object_address" id="object_address" placeholder="Адрес"
            autocomplete="off">
    </div>
    <div class="inputLine">
        <span class="inputText">Площадь</span>
        <input class="input font__input" type="text" name="object_area" id="object_area" placeholder="Площадь"
            autocomplete="off">
    </div>
    <div class="inputLine">
        <span class="inputText">Тариф Обслуживания</span>
        <input class="input font__input" type="text" name="management_fee" id="management_fee"
            placeholder="Тариф Обслуживания" autocomplete="off">
    </div>
    <div class="inputLine">
        <span class="inputText">Тариф Текущего Ремонта</span>
        <input class="input font__input" type="text" name="current_repair_rate" id="current_repair_rate"
            placeholder="Тариф Текущего Ремонта">
    </div>
    <div class="inputLine">
        <input class="submit font__input" type="submit" value="Подтвердить" onclick="submitForm()">
    </div>
</form>

<?php
require_once '../../src/templates/footer.php';
?>