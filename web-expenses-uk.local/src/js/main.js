// Общая функция для взаимодействия с данными

function clickNavBtn(value, database, headers) {
    const windowInput = document.getElementById('window__input');
    const headerNodeList = document.querySelectorAll('th');

    let inputMenu = ``;

    if (value == "Create") {
        let lengthArray = headers.length;

        for (let i = 0; i < lengthArray; i++) {
            valName = headerNodeList[i].textContent;

            if (headers[i].name == "id") {
                valValue = database.length + 1;
            } else if (headers[i].name == "object_address") {
                valValue = "г. Тверь, ул/пер.";
            } else {
                valValue = ""
            }

            inputMenu += `
        <div class="input__block">
            <div class="block__element">${valName}</div>
            <div class="block__element"><input class="font__input" type="text" name="${headers[i].name}" value="${valValue}" placeholder="Введите ${valName}"></div>
        </div>`;
        }
        inputMenu += `
        <div class="input__block">
            <button class="font__input" type="submit">Отправить данные</button>
        </div>`;

        windowInput.innerHTML = inputMenu;

        const form = document.getElementById('window__input');

        form.onsubmit = function(event) {
            event.preventDefault();

            submitFormData(form);
        };
    } else if (value == "Change") {
        windowInput.innerHTML = value;
    } else if (value == "Delete") {
        let lengthArray = database.length;

        inputMenu += `
        <div class="input__block">
            <div class="block__element">id</div>
            <div class="block__element">
                <input class="font__input" list="id_deleted" type="text" name="id" placeholder="Введите">
                <datalist id="id_deleted">`

        for (let i = 0; i < lengthArray; i++) {
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