Реализованы методы REST API для работы с пользователями: 
 - Авторизация пользователя - AuthController, метод login
 - Разлогинивание - AuthController, метод logout
 - Регистрация Создание пользователя - RegistrationController, метод register
 - Обновление информации пользователя - UserController, метод edit
 - Смена пароля пользователя - UserController, метод editPass
 - Удаление пользователя  - UserController, метод delete
 - Получить информацию о пользователе - UserController, метод user
Для реализации создана база данных Postgres, миграции находятся в папке migrations.
Также реализован простейшй фронт без стилей и каких-либо украшений.
