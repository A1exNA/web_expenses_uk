export const dbList = ['objects', 'users', 'expens'];

export async function searchBtnOld(btnName, dbName) {
    const windowInput = document.getElementById('window__input');
    const headerHTMLNodeList = document.querySelectorAll('th');

    let headerNodeList = [];

    for (let i = 0; i < headerHTMLNodeList.length; i++) {
        headerNodeList.push(headerHTMLNodeList[i].textContent);
    }

    const actionUrl = '../../src/database/fetcher.php';
    const response = await fetch (actionUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: btnName, dbName: dbName, ruHeaders: headerNodeList })
    })

    if (!response.ok) {
        throw new Error(`Ошибка сервера: ${response.status}`)
    };

    const data = await response.json();

    console.log(data);

    const headers = data['headers'];
    const database = data['database'];

    windowInput.innerHTML = data['innerHTML'];

    const form = document.getElementById('window__input');

    form.onsubmit = function(event) {
        event.preventDefault();

        const formData = new FormData(form, event.submitter);

        const action = formData.get('action');
        console.log('Начало обработки');
        if (action == 'save') {
            const actionUrl = '../../src/database/data_exchange.php'

            fetch (actionUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: btnName, dbName: dbName, data: Object.fromEntries(formData), database: data })
            })
            .then (response => {
                console.log(response);
                return response.json();
            })
            .then (data => {
                console.log(data);

                if (data.status === 'success') {
                    window.location.reload();
                }
            })
        } else if (action == 'new_expens') {
            console.log('Добавляем новый элемент товара');
            console.log(form)

            const buttonBlock = event.submitter.closest('.input__block');

            const blockToCopy = buttonBlock.previousElementSibling;
            
            const newNode = blockToCopy.cloneNode(true);const inputs = newNode.querySelectorAll('input');
            
            inputs.forEach(input => {
                input.value = '';
            });
            
            const label = newNode.querySelector('#expens');
            if (label) {
                const allItems = form.querySelectorAll('.input__line__id').length + 1;
                label.textContent = `Товар №${allItems}`;
            }

            form.insertBefore(newNode, buttonBlock);
        }
    }

    if (btnName == "Change") {
        const inputElement = document.getElementById('input')

        inputElement.addEventListener('change', function(event) {
            const selectedValue = event.target.value;

            console.log('Введено число', selectedValue);
            console.log(headers, database);

            for (let i = 1; i < headers.length; i++) {
                const element = document.getElementById(headers[i]['name']);

                for (let j = 0; j < database.length; j++) {
                    if (!selectedValue) {
                        console.log('Выберете id');
                        element.value = '';
                        break;

                    } else if (database[j]['id'] == selectedValue) {
                        element.value = database[j][headers[i]['name']];
                        break;
                    }
                }
            }
        })
    } else if (!["Create", "Change", "Delete"].includes(btnName)) {
        console.log("Что-то непонятное");
        windowInput.innerHTML = '';
    }
}