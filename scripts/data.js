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
        login.textContent = json.login;

        // Тут можно вставить код который берёт данные из API Instagram.
    }
}