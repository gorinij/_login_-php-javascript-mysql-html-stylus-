<?php
/**
 * Created by PhpStorm.
 * User: hardriser
 * Date: 10.09.2015
 * Time: 20:50
 */

namespace app\model;

class CLocalization
{
    const
        LOCALE_RU = 0,
        LOCALE_EN = 1;

    public function __construct()
    {
        $this->initLocals();
    }

    /**
     * Локализовать все текстовые значения
     * @param   $locale Язык на который нужно локализовать
     * @return  Возвращает локализованный массив всех полей
     */
    public static function localizateAllFields($locale)
    {
        if (
            $locale !== self::LOCALE_RU &&
            $locale !== self::LOCALE_EN
        ) $locale = self::LOCALE_RU;
        $res = CDBConnection::executeQuery('SELECT `name`, `value` FROM `locale` WHERE `loc` = ' . $locale . '');
        foreach ($res as $r) {
            $name = $r[name];
            $rResult[$name] = $r[value];
        }
        return $rResult;
    }

    /**
     * Локализовать конкретное текстовое значение
     * @param $locale   Язык на который нужно локализовать
     * @param $field    Поле, которое необходимо локализовать
     * @return  Возвращает локализованный значение поля
     */
    public static function localizateField($locale, $field)
    {
        if (
            $locale !== self::LOCALE_RU &&
            $locale !== self::LOCALE_EN
        ) $locale = self::LOCALE_RU;
        $res = CDBConnection::executeQuery('SELECT `value` FROM `locale` WHERE `name` = "' . $field . '" AND `loc` = ' . $locale);
        return $res[0][0];
    }

    /**
     * Инициализирует таблицу с локализованными значениями основных текстов
     */
    private function initLocals()
    {
        ob_start(); // Вся выводимая информация заносится в буфер

        echo <<<QUERY
        CREATE TABLE IF NOT EXISTS `locale` (
            `id` int(12) AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(25),
            `value` VARCHAR(100),
            `loc` SMALLINT
        );
QUERY;
        $sqlQuery = ob_get_contents(); // Полечаем данные из буфера
        CDBConnection::executeQuery($sqlQuery);
        ob_end_clean(); // Завершить вывод информации в буфер и очистить ее


        /**
         * Если в таблице нет записей, то инициализировать основные данные
         */
        if (CDBConnection::executeQuery('SELECT COUNT(`id`) FROM `locale`')[0]['COUNT(`id`)'] < 1) {
            ob_start();
            echo <<<QUERY
        INSERT INTO `locale` (
            `name`,
            `value`,
            `loc`
        ) VALUE
QUERY;
            echo '("lastname", "Фамилия", 0), ';
            echo '("firstname", "Имя", 0), ';
            echo '("patroname", "Отчество", 0),';
            echo '("login", "Логин", 0),';
            echo '("password", "Пароль", 0),';
            echo '("passwordConfirm", "Подтверждение пароля", 0),';
            echo '("email", "Введите ваш Email", 0),';
            echo '("emailConfirm", "Подтверждение пароля", 0),';
            echo '("gender", "Пол", 0),';
            echo '("gender_man", "Мужской", 0),';
            echo '("gender_woman", "Женский", 0),';
            echo '("phone", "Телефон", 0),';
            echo '("question", "Секретный вопрос", 0),';
            echo '("answer", "Ответ", 0),';
            echo '("addEmail", "Дополнительный Email", 0),';
            echo '("addEmailConfirm", "Пордтвердить дополнительный Email", 0),';
            echo '("birthday", "День рождения", 0),';
            echo '("birthDay", "День", 0),';
            echo '("birthMonth", "Месяц", 0),';
            echo '("birthYear", "Год", 0),';
            echo '("chooseCountry", "Выберите Страну", 0),';
            echo '("chooseCity", "Выберите Город", 0),';

            echo '("validPasswordNull", "Пароль должен быть длиннее шести символов", 0), ';
            echo '("validPasswordNEqual", "Пароли не совпадают", 0), ';
            echo '("validPasswordNull", "Количество цыфр в номере находится за пределами допустимого диапозона", 0), ';
            echo '("validPasswordNEqual", "Введите в качестве номера только цифры", 0), ';
            echo '("validPhoneRange", "Поле ввода имени пользователя не может начинаться с цыфры", 0), ';
            echo '("validPhoneOnlyDig", "Логин может состоять только из английских бувк, цифр и знака подчеркивания", 0), ';
            echo '("validLoginNDig", "Поле ввода имени пользователя не может начинаться с цыфры", 0), ';
            echo '("validLoginABC", "Логин может состоять только из английских бувк, цифр и знака подчеркивания", 0), ';
            echo '("validLoginNABC", "Логин содержит недопустимые символы", 0), ';
            echo '("validPasswordShort", "Слишком короткий пароль. Как минимум 6 символов", 0), ';
            echo '("validLastnameABC", "Фамилия не может содержать какие-либо другие символы кроме букв", 0), ';
            echo '("validFirstnameABC", "Имя не может содержать какие-либо другие символы кроме букв", 0), ';
            echo '("validPatronameABC", "Отчество не может содержать какие-либо другие символы кроме букв", 0), ';
            echo '("validInvalEmailFormat", "Введен неправильный формат email", 0), ';
            echo '("validEmailNEqual", "Введенная почта не одинакова", 0), ';
            echo '("validEmailMainAndAddEqual", "Основной Email и дополнительный Email должны отличаться друг от друга", 0), ';
            echo '("cityMsk", "Москва", 0), ';
            echo '("cityWsh", "Вашингтон", 0), ';
            echo '("cityPrs", "Париж", 0), ';
            echo '("cityTky", "Токио", 0), ';
            echo '("cityNyk", "Нью-Йорк", 0), ';
            echo '("cityMrs", "Марсель", 0), ';
            echo '("citySpb", "Санкт-Питербург", 0), ';
            echo '("cityBrl", "Берлин", 0), ';
            echo '("cityRam", "Рамштайн", 0), ';
            echo '("cityKyo", "Киото", 0), ';

            echo '("place", "Месторасположение", 0), ';
            echo '("place_country_ru", "Россия", 0),';
            echo '("place_country_fr", "Франция", 0),';
            echo '("place_country_jp", "Япония", 0),';
            echo '("place_country_gr", "Германия", 0),';
            echo '("place_country_us", "Соединенный Штаты", 0),';
            echo '("place_city_msc", "Москва", 0),';
            echo '("place_city_brl", "Берлин", 0),';
            echo '("place_city_wsh", "Вашингтон", 0),';
            echo '("place_city_tky", "Токио", 0),';
            echo '("place_city_mrs", "Марсель", 0),';
            echo '("place_address", "Адрес", 0),';
            echo '("registration", "Регистрация", 0),';
            echo '("chooseLanguage", "Язык", 0),';
            echo '("whatIsYourName", "Как вас зовут", 0),';
            echo '("genderAndDate", "Укажите ваш пол и дату вашегорождения", 0),';
            echo '("loginPasswordQuestion", "Придумайте имя пользователя, пароль и секретный вопрос", 0),';
            echo '("enterYourEmail", "Введите ваш основной и дополнительный Email", 0),';
            echo '("contactData", "Введите ваш номер телефона и адрес места проживания", 0),';
            echo '("birthMonth_jan", "Январь", 0),';
            echo '("birthMonth_feb", "Февраль", 0),';
            echo '("birthMonth_mar", "Март", 0),';
            echo '("birthMonth_apr", "Апрель", 0),';
            echo '("birthMonth_may", "Май", 0),';
            echo '("birthMonth_jun", "Июнь", 0),';
            echo '("birthMonth_jul", "Июль", 0),';
            echo '("birthMonth_aug", "Август", 0),';
            echo '("birthMonth_sep", "Сентябрь", 0),';
            echo '("birthMonth_okt", "Окрябрь", 0),';
            echo '("birthMonth_nov", "Ноябрь", 0),';
            echo '("birthMonth_dec", "Декабрь", 0),';
            echo '("toRegistration", "или вы еще незарегистрированы?", 0), ';
            echo '("rememberMe", "Запомнить меня", 0), ';
            echo '("validationError", "ошибка валидации", 0),';
            echo '("signin", "Вход", 0),';
            echo '("uploadPhoto", "Загрузить фотографию", 0),';
            echo '("photoUpload", "Фотография загружена", 0),';
            echo '("bio", "Био", 0),';
            echo '("contactData", "Контактные данные", 0),';
            echo '("mainEmail", "Основной Email", 0),';
            echo '("additEmail", "Доп. Email", 0),';
            echo '("livePlace", "Адрес проживания", 0),';
            echo '("authError", "Ошибка аутентификации. <br/> Неправильный логин или пароль.", 0),';
            echo '("signinSuccess", "Вы вошли успешно", 0), ';
            echo '("signupSuccess", "Регистрация успешно завершена", 0), ';


            echo '("validPasswordNull", "The password should be longer than six characters", 1), ';
            echo '("validPasswordNEqual", "Password mismatch", 1), ';
            echo '("validPhoneRange", "Field user name can not start with digits", 1), ';
            echo '("validPhoneOnlyDig", "Enter the numbers as digits only", 1), ';
            echo '("validLoginNDig", "Field Login can not start with digits", 1), ';
            echo '("validLoginABC", "Login may only consist of english chars, numbers, and the underscore", 1), ';
            echo '("validLoginNABC", "Login contains invalid characters", 1), ';
            echo '("validPasswordShort", "Too short password. At least 6 characters", 1), ';
            echo '("validLastnameABC", "Lastname can not contain any characters other than letters", 1), ';
            echo '("validFirstnameABC", "Firstname can not contain any characters other than letters", 1), ';
            echo '("validPatronameABC", "Patroname can not contain any characters other than letters", 1), ';
            echo '("validInvalEmailFormat", "Introduced invalid email format", 1), ';
            echo '("validEmailNEqual", "The entered e-mail is not equal", 1), ';
            echo '("validEmailMainAndAddEqual", "The main Email and additional Email must be different from each other", 1), ';
            echo '("cityMsk", "Moscow", 1), ';
            echo '("cityWsh", "Washington", 1), ';
            echo '("cityPrs", "Paris", 1), ';
            echo '("cityTky", "Tokyo", 1), ';
            echo '("cityNyk", "New-York", 1), ';
            echo '("cityMrs", "Marsel", 1), ';
            echo '("citySpb", "St. Petersburg", 1), ';
            echo '("cityBrl", "Berlin", 1), ';
            echo '("cityRam", "Ramstain", 1), ';
            echo '("cityKyo", "Kyoto", 1), ';

            echo '("chooseCountry", "Choose the Country", 1),';
            echo '("chooseCity", "Choose the City", 1),';

            echo '("lastname", "Lastname", 1),';
            echo '("firstname", "Firstname", 1),';
            echo '("patroname", "Patroname", 1),';
            echo '("login", "Login", 1),';
            echo '("password", "Password", 1),';
            echo '("passwordConfirm", "Confirm the password", 1),';
            echo '("email", "Enter your Email", 1),';
            echo '("emailConfirm", "Confirm your Email", 1),';
            echo '("gender", "Gender", 1),';
            echo '("gender_man", "Man", 1),';
            echo '("gender_woman", "Woman", 1),';
            echo '("phone", "Phone number", 1),';
            echo '("question", "Secret question", 1),';
            echo '("answer", "Answer", 1),';
            echo '("addEmail", "Additional Email", 1),';
            echo '("addEmailConfirm", "Confirm additional Email", 1),';
            echo '("birthday", "Birthday", 1),';
            echo '("birthDay", "Day", 1),';
            echo '("birthMonth", "Month", 1),';
            echo '("birthYear", "Year", 1),';
            echo '("place", "Place", 1), ';
            echo '("place_country_ru", "Russia", 1),';
            echo '("place_country_fr", "France", 1),';
            echo '("place_country_jp", "Japan", 1),';
            echo '("place_country_gr", "German", 1),';
            echo '("place_country_us", "USA", 1),';
            echo '("place_city_msc", "Moscow", 1),';
            echo '("place_city_brl", "Berlin", 1),';
            echo '("place_city_wsh", "Washington", 1),';
            echo '("place_city_tky", "Tokyo", 1),';
            echo '("place_city_mrs", "Marsel", 1),';
            echo '("place_address", "Street, home", 1),';
            echo '("registration", "Registration", 1),';
            echo '("chooseLanguage", "Language", 1),';
            echo '("whatIsYourName", "What is your name", 1),';
            echo '("genderAndDate", "Select your gender and birthday", 1),';
            echo '("loginPasswordQuestion", "Input your login, password and secret question", 1),';
            echo '("enterYourEmail", "Enter your main and additional Email", 1),';
            echo '("contactData", "Enter your phone number and your address", 1),';
            echo '("birthMonth_jan", "January", 1),';
            echo '("birthMonth_feb", "February", 1),';
            echo '("birthMonth_mar", "March", 1),';
            echo '("birthMonth_apr", "April", 1),';
            echo '("birthMonth_may", "May", 1),';
            echo '("birthMonth_jun", "June", 1),';
            echo '("birthMonth_jul", "July", 1),';
            echo '("birthMonth_aug", "August", 1),';
            echo '("birthMonth_sep", "September", 1),';
            echo '("birthMonth_okt", "October", 1),';
            echo '("birthMonth_nov", "November", 1),';
            echo '("birthMonth_dec", "December", 1),';
            echo '("toRegistration", "or you wish signup?", 1),';
            echo '("rememberMe", "Remember me", 1),';
            echo '("validationError", "validation error", 1),';
            echo '("signin", "Signin", 1),';
            echo '("uploadPhoto", "Upload photo", 1),';
            echo '("photoUpload", "Photo is upload", 1),';
            echo '("bio", "Bio", 1),';
            echo '("contactData", "Contact data", 1),';
            echo '("mainEmail", "Main Email", 1),';
            echo '("additEmail", "Add. Email", 1),';
            echo '("livePlace", "Live place", 1),';
            echo '("authError", "Authentication error. <br/> Wrong login or password.", 1),';
            echo '("signinSuccess", "You entered success", 1), ';
            echo '("signupSuccess", "Registration success completed", 1); ';

            $sqlQuery = ob_get_contents();
            CDBConnection::executeQuery($sqlQuery);

            ob_end_clean();
        }
    }
}