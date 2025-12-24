// Загрузка бд при открытии страницы

dbList = ['objects', 'expenses', 'users'];

document.addEventListener('DOMContentLoaded', loadData(dbName));


// Функция на поиск headers и database

async function dataSearch(dbName) {
    if (!dbList.includes(dbName)) {
        return null;
    };
    const actionUrl = '../../src/database/server.php';

    try {
        const response = await fetch(actionUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'dbData', dbName: dbName })
        });

        if (!response.ok) {
            throw new Error(`Ошибка сервера: ${response.status}`);
        };
        const data = await response.json();
        return {
            headers: data.dbHeaders,
            database: data.dbData
        }
    } catch (error) {
        console.error('Не удалось загрузить данные: ', error.message);
    };
}

// Функция на вывод данных

async function loadData(dbName) {
    if (!dbList.includes(dbName)) {
        return null;
    };
    const dbData = await dataSearch(dbName);
    const actionUrl = '../../src/database/server.php';

    try {
        const response = await fetch(actionUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ action: 'loadData', headers: dbData['headers'], database: dbData['database'] })
        });

        if (!response.ok) {
            throw new Error(`Ошибка сервера: ${response.status}`);
        };
        const data = await response.json();
        const form = document.getElementById('db_table');
        form.insertAdjacentHTML('beforeend', data['innerHTML']);
    } catch (error) {
        console.error('Не удалось загрузить данные: ', error.message);
    };
}


// Общая функция для взаимодействия с данными

async function clickNavBtn(value, dbName) {
    const dataS =  await dataSearch(dbName);
    headers = dataS['headers'];
    database = dataS['database'];

    const windowInput = document.getElementById('window__input');
    const headerNodeList = document.querySelectorAll('th');

    const actionUrl = '../../src/database/fetcher.php';
    const response = await fetch (actionUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: value, headers: headers, database: database })
    })

    if (!response.ok) {
        throw new Error(`Ошибка сервера: ${response.status}`)
    };

    const data = await response.json();

    console.log(data);

    windowInput.innerHTML = data['innerHTML'];

    if (value == "Create") {
        const form = document.getElementById('window__input');

        form.onsubmit = function(event) {
            event.preventDefault();

            submitFormData(form);
        };
    } else if (value == "Change") {
        const inputElement = document.getElementById('input')

        inputElement.addEventListener('change', function(event) {
            const selectedValue = event.target.value;

            console.log('Введено число', selectedValue);
            console.log(headers, database);

            for (let i = 1; i < headers.length; i++) {
                element = document.getElementById(headers[i]['name']);

                for (let j = 0; j < database.length; j++) {
                    if (!selectedValue) {
                        console.log('Выберете id');
                        element.value = '';
                        break;

                    } else if (database[j]['id'] == selectedValue) {
                        console.log(database[j][headers[i]['name']]);

                        element.value = database[j][headers[i]['name']];
                        break;
                    }
                }
            }
        })

        const form = document.getElementById('window__input');

        form.onsubmit = function(event) {
            event.preventDefault();

            changeFormData(form);
        };
    } else if (value == "Delete") {
        let lengthArray = database.length;



        inputMenu += `
        <div class="input__block">
            <div class="block__element">id</div>
            <div class="block__element">
                <input class="font__input" list="id_deleted" type="text" name="id" placeholder="Введите id" autocomplete="off">
                <datalist id="id_deleted">`

        for (let i = 0; i < lengthArray; i++) {
            console.log(database);
            inputMenu += `
                <option value="${database[i][0]}">${database[i][1]}`
        }


        inputMenu += `
                </datalist>
            </div>
        </div>`

        inputMenu += `
        <div class="input__block">
            <button class="font__input" type="submit">Удалить данные</button>
        </div>`;

        windowInput.innerHTML = inputMenu;

        const form = document.getElementById('window__input');

        form.onsubmit = function(event) {
            event.preventDefault();

            deleteFormData(form);
        };
    } else {
        console.log("Что-то непонятное");
        windowInput.innerHTML = inputMenu;
    }
}


// Функция добавления данных в БД

function submitFormData(formElement) {
    const formData = new FormData(formElement);

    console.log('Начало обработки')

    const actionUrl = '../../src/database/submit_data.php'

    fetch(actionUrl, {
        method: 'POST',
        body: formData,
    })
    .then(respons => {
        console.log("Status: " , respons.status);

        return respons.json();
    })
    .then(data => {
        console.log(data);

        if (data.status === 'success') {
            window.location.reload();
        }
    })
}


// Функция изменения данных в БД

function changeFormData(formElement) {
    const formData = new FormData(formElement);

    console.log('Начало обработки', formData);

    const actionUrl = '../../src/database/change_data.php'

    fetch(actionUrl, {
        method: 'POST',
        body: formData
    })
    .then(respons => {
        console.log("Status: " , respons.status);

        return respons.json();
    })
    .then(data => {
        console.log(data);

        if (data.status === 'success') {
            window.location.reload();
        }
    })
}


// Функция удаления данных в БД

function deleteFormData(formElement) {
    const formData = new FormData(formElement);

    console.log('Начало обработки', formData.get('id'))

    const actionUrl = '../../src/database/delete_data.php'

    fetch(actionUrl, {
        method: 'POST',
        body: formData
    })
    .then(respons => {
        console.log("Status: " , respons.status);

        return respons.json();
    })
    .then(data => {
        console.log(data);

        if (data.status === 'success') {
            window.location.reload();
        }
    })
}