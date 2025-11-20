function submitForm() {
    const data = {
        id: document.getElementById('id'),
        object_address: document.getElementById('object_address'),
        object_area: document.getElementById('object_area'),
        management_fee: document.getElementById('management_fee'),
        current_repair_rate: document.getElementById('current_repair_rate'),
    }

    if(data['id'].value == 1) {
        data['id'].style.color = 'red'
    } else {
        console.log(data['id'].value);
        console.log(data['object_address'].value);
        console.log(data['object_area'].value);
        console.log(data['management_fee'].value);
        console.log(data['current_repair_rate'].value);
    }
}