<form id="auth_form" action="#" method="post">
    <fieldset>
        <legend> <span>Авторизация</span></legend>
        <p class="error_handler">Введите логин и пароль!</p>

        <input type="text" name="login" placeholder="user1" autocomplete="on" required />
        <input type="password" name="password" placeholder="123" autocomplete="on" required />

        <label> <input type="radio" name="type" value="register"> Регистрация </label>

        <label> <input type="radio" name="type" value="auth" checked> Авторизация </label>

        <input class="button" type="submit" value="Авторизоваться" />
    </fieldset>
</form>