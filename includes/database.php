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
        $config = require_once __DIR__ . './../config/database.php';
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

    public static function auth_user($log, $pas) {
        $login = self::$database->quote($log);
        $password = self::$database->quote($pas);

        $query = "SELECT id_user, user_password FROM `users` WHERE user_login = $login;";
        
        $sth = self::$database->prepare($query);
        $sth->execute();
        $user_data = $sth->fetch(\PDO::FETCH_ASSOC);

        $password_compare = password_verify($password, $user_data['user_password']);
        if ($password_compare) {
            $user_id = $user_data['id_user'];
            $token = bin2hex(random_bytes(16));

            $query = "INSERT INTO `tokens` (`token_value`, `token_user`) VALUES ('$token', '$user_id');";
            $sucess = self::$database->prepare($query)->execute();
            if ($sucess) {
                setcookie("token", $token);
                return true;
            }
        }
        return false;
    }

    public static function register_user($log, $pas) {
        $login = self::$database->quote($log);
        $password = self::$database->quote($pas);

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "SELECT * FROM `users` WHERE user_login = $login;";

        $user_count = self::$database->prepare($query)->rowCount();
        
        if ($user_count == 0) {
            $query = "INSERT INTO `users` (`id_user`, `user_login`, `user_password`) VALUES (NULL, $login, '$hash_password');";
            self::$database->prepare($query)->execute();
            return true;
        }

        return false;
    }
}