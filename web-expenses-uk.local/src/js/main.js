// Общая функция для взаимодействия с данными

import { searchBtnOld, dbList } from "./btn.js";

async function clickNavBtn(btnName, dbName) {
    searchBtnOld(btnName, dbName);
}
window.clickNavBtn = clickNavBtn;


// Загрузка бд при открытии страницы

document.addEventListener('DOMContentLoaded', loadData(dbName));


// Функция на вывод данных

async function loadData(dbName) {
    if (!dbList.includes(dbName)) {
        return null;
    }
    const actionUrl = '../../src/database/server.php';

    try {
        const response = await fetch(actionUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ action: 'loadData', dbName: dbName })
        });

        if (!response.ok) {
            throw new Error(`Ошибка сервера: ${response.status}`);
        }
        const data = await response.json();
        console.log(data);
        const form = document.getElementById('db_table');
        form.insertAdjacentHTML('beforeend', data['innerHTML']);
    } catch (error) {
        console.error('Не удалось загрузить данные: ', error.message);
    }
}