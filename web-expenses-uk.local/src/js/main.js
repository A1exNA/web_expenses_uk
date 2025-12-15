// Общая функция для взаимодействия с данными

function clickNavBtn(value, database, headers) {
    const windowInput = document.getElementById('window__input');
    const headerNodeList = document.querySelectorAll('th');

    let inputMenu = ``;

    if (value == "Create") {
        let lengthArray = headers.length;

        for (let i = 0; i < lengthArray; i++) {
            valName = headers[i].name;
            valName = headerNodeList[i].textContent;
            inputMenu += `
        <div class="input__block">
            <div class="block__element">${valName}</div>
            <div class="block__element"><input class="font__input" type="text" name="${headers[i].name}" placeholder="Введите ${valName}"></div>
        </div>`;
        }
        inputMenu += `
        <div class="input__block">
            <button class="font__input" type="submit">Отправить данные</button>
        </div>`;

        windowInput.innerHTML = inputMenu;

        const form = document.getElementById('window__input');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            submitFormData(form);
        });
    } else if (value == "Change") {
        windowInput.innerHTML = value;
    } else if (value == "Delete") {
        windowInput.innerHTML = value;

        inputMenu += `
        <div class="input__block">
            <div class="block__element">id</div>
            <div class="block__element">
                <input class="font__input" list="id_deleted" type="text" name="" placeholder="Введите">
                <datalist id="id_deleted">
                    <option value="1">г. Тверь, пер. Беляковский, д. 42
                    <option value="2">г. Тверь, ул. Веры Бонч-Бруевич, д. 26
                    <option value="3">г. Тверь, ул. Ефимова, д. 32
                </datalist>
            </div>
        </div>`

        inputMenu += `
        <div class="input__block">
            <button class="font__input" type="submit">Удалить данные</button>
        </div>`;

        windowInput.innerHTML = inputMenu;
    } else {
        console.log("Что-то непонятное");
        windowInput.innerHTML = inputMenu;
    }
}

// Функция добавления данных в БД

function submitFormData(formElement) {
    const formData = new FormData(formElement);

    const actionUrl = '../../src/database/submit_data.php'
    console.log('Начало обработки')

    fetch(actionUrl, {
        method: 'POST',
        body: formData,
    })
    .then(respons => {
        console.log("Status: " , respons.status);
        console.log("Headers: " , respons.headers);

        return respons.json();
    })
    .then(data => {
        console.log(data);

        if (data.status === 'success') {
            window.location.reload();
        }
    })
}