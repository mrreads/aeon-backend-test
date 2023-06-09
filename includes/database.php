<?php

class Database
{
    public static $database;
    public static $connected = false;

    public function __construct()
    {
        $this->connect();
    }
    
    public static function connect()
    {
        $config = [
            'host' => '127.0.0.1',
            'dbname' => 'aeon-backend',
            'user' => 'root',
            'password' => ''
        ];
        $connection = 'mysql:dbname=' . $config['dbname'] . ';host=' . $config['host'];
        try
        {
            self::$database = new PDO($connection, $config['user'], $config['password']);
            self::$connected = true;
        }
        catch (\PDOException $e)
        {
            exit($e->getMessage('Не удалось подключится к базе данных.'));
        }
    }

    // Проверяем токен в куках на валидность
    public static function check_auth($tok) {
        $token = self::$database->quote($tok);

        $query = "SELECT token_user FROM `tokens` WHERE token_value = $token;";
        $sth = self::$database->prepare($query);
        $sth->execute();
        $token_user = $sth->fetch(\PDO::FETCH_ASSOC);

        if ($token_user) {
            return $token_user['token_user'];
        }
        else {
            return false;
        }
    }

    // При поптыке захода записываем количество авторизаций в куки.
    // Если попыток более 9 = запрещаем логиниться на 30 секунд. И отчёт запускается по новой.
    public static function check_bruteforce() {
        $auth_count = 1;
        if (isset($_COOKIE['auth_count'])) {
            $auth_count = $_COOKIE['auth_count'] + 1;
        }
        setcookie("auth_count", $auth_count, time() + 3600, "/"); // 1 час

        if ($auth_count > 9) {
            return true;
        }
        return false;
    }

    // Авторизация, устанавливает токен в куки
    public static function auth_user($log, $pas) {
        $login = self::$database->quote($log);
        $password = self::$database->quote($pas);

        // Смотрим на условие, больше 9 попыток или нет
        // Если сработала защита - не даст авторизоваться даже с верными данными
        if (self::check_bruteforce() == true)
        {
            setcookie("auth_count", 99, time() + 30, "/"); // 30 секунд
            return "bruteforce";
        }

        // Извлекаем хеш пароля, чтобы потом сравнить его с оригинальным
        $query = "SELECT id_user, user_password FROM `users` WHERE user_login = $login;";
        
        $sth = self::$database->prepare($query);
        $sth->execute();
        $user_data = $sth->fetch(\PDO::FETCH_ASSOC);

        if ($user_data) {
            $password_compare = password_verify($password, $user_data['user_password']);
        }
        else {
            return false;
        }

        if ($password_compare) {
            $user_id = $user_data['id_user'];
            $token = bin2hex(random_bytes(16));

            $query = "INSERT INTO `tokens` (`token_value`, `token_user`) VALUES ('$token', '$user_id');";
            $sucess = self::$database->prepare($query)->execute();
            if ($sucess) {
                // Храним токен для проверки авторизации
                setcookie("token", $token, time() + (60 * 60 * 24 * 3), "/"); // 3 дня
                return true;
            }
        }
        return false;
    }

    public static function get_user($id) {
        $id = self::$database->quote($id);

        $query = "SELECT user_login, user_name, user_image, user_date FROM `users` WHERE id_user = $id;";
        $sth = self::$database->prepare($query);
        $sth->execute();
        $user = $sth->fetch(\PDO::FETCH_ASSOC);

        if ($user['user_login']) {
            return $user;
        }
        return false;
    }

    public static function register_user($log, $pas) {
        $login = self::$database->quote($log);
        $password = self::$database->quote($pas);

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "SELECT * FROM `users` WHERE user_login = $login;";

        $sth = self::$database->prepare($query);
        $sth->execute();
        $user_count = $sth->rowCount();
        
        if ($user_count == 0) {
            $query = "INSERT INTO `users` (`id_user`, `user_login`, `user_password`, `user_name`, `user_image`, `user_date`) VALUES (NULL, $login, '$hash_password', 'Иван Иванов', '/uploads/default-avatar.png', CURRENT_DATE());";
            self::$database->prepare($query)->execute();
            return true;
        }

        return false;
    }
}