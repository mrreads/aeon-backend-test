const error_handler = document.querySelector('.error_handler');
const auth_form = document.querySelector("#auth_form");
auth_form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = new FormData(auth_form);
    const type = form.get('type');
    
    var formdata = new FormData();
    formdata.append("login", form.get('login'));
    formdata.append("password", form.get('password'));

    const headers = {
        method: 'POST',
        body: formdata
    }

    if (type == 'auth') {
        const response = await fetch("./../includes/auth.php", headers);
        const json = await response.json();
        console.log(json);

        if (json.success == 'bruteforce') {
            error_handler.textContent = "Слишком быстро. Подожди 30 секунд."
            return true;
        }
        
        if (json.success == true) {
            document.body.dataset.auth = true;

            let alert = document.createElement('div');
            alert.classList.add('alert');
            alert.textContent = 'Вы успешно вошли!';
            alert.addEventListener('click', () => alert.remove());

            document.body.appendChild(alert);
            setTimeout(() => {
                if (alert)
                    alert.remove();
            }, 10_000);
        }
        else {
            error_handler.textContent = "Ошибка! Неверно введены данные."
        }
    }

    // Регистрация
    if (type == 'register') {
        const response = await fetch("./../includes/register.php", headers);
        const json = await response.json();
        
        if (json.success) {
            error_handler.textContent = "Вы зарегистрировались."
        }
        else {
            error_handler.textContent = "Ошибка регистрации."
        }
    }
});