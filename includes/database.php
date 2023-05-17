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
    public static function auth_user($log, $pas) {
        $login = self::$database->quote($log);
        $password = self::$database->quote($pas);

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
                setcookie("token", $token, time() + 3600, "/");
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