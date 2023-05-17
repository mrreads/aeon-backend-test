const observer = new MutationObserver((list) => detect_auth());
observer.observe(document.body, { attributes: true });

if (document.body.dataset.auth)
    loading_data();

const detect_auth = () => {
    let auth = document.body.dataset.auth;
    if (auth)
        loading_data();
}

async function loading_data() {
    const response = await fetch("./../includes/get_data.php");
    const json = await response.json();
    if (json.success) {
        const login = document.querySelector('.login');
        const name = document.querySelector('.name');
        const date = document.querySelector('.date');
        const avatar = document.querySelector('.avatar');

        login.textContent = json.data.user_login;
        name.textContent = json.data.user_name;
        date.textContent = json.data.user_date;
        avatar.src = json.data.user_image;

        // Тут можно вставить код который берёт данные из API Instagram.
    }
}