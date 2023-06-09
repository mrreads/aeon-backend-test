# Тестовое задание

## 2. PHP/JS

- **PHP** и **JavaScript**
- Версия **PHP** на которой проверена работоспособность - **8.1**
- Данные подключения к **базе данных** расположены в ``./includes/database.php`` − _$config_
- Пароли шифруются с помощью **password_hash()**


## Защита от брутфорса
Защита от брутфорса реализована через **Cookie**.

В куки находится ``auth_count``, который по умолчанию живёт **1 час**.

Если попыток авторизации **больше 9**, то блокируем возможность авторизоваться (_но не зарегистрироваться_) на **30 секунд**.

Блокируется путём перезаписи куки ``auth_count``, которая истекает по истечению **30 секунд**.

Каждая попытка авторизоваться при заблокированной авторизации **обновляет счётчик**.
## Структура проекта
```
.
├── includes
│   ├── auth.php       # Логика асинхронной авторизации для fetch
│   ├── database.php   # Класс работы с базой данных (и данные для коннекта)
│   ├── get_data.php   # Асинхронное получение инфы о юзере для fetch
│   ├── is_login.php   # Проверка авторизованы ли мы, смотрит на cookie
│   ├── logout.php     # Выход из аккаунта, для классической формы
│   └── register.php   # Логика асинхронной регистрации для fetch
│  
├── scripts
│   ├── auth.js        # Запросы на авторизацию/регистрацию и отрисовка блоков
│   └── data.js        # Вотчер, следит за авторизацией и подгружает данные
│  
├── styles
│   └── general.css    # Стили
│  
├── view
│   ├── auth.php       # Разметка для авторизации
│   └── info.php       # Разметка для данных пользователя
│ 
├── aeon-backend.sql   # Бэкап базы данных для MySQL
│ 
├── favicon.ico
└── index.php
```

## Структура базы данных

![Структура базы данных](https://i.ibb.co/NnfFwyr/database.jpg)


## Скриншоты

![Авторизация](https://i.ibb.co/Y2j91kt/1.jpg)
![Данные](https://i.ibb.co/C923JPH/2.jpg)