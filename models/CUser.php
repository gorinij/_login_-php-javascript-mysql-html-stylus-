<?php
/**
 * Created by PhpStorm.
 * User: hardriser
 * Date: 10.09.2015
 * Time: 22:56
 */

/*
 * ToDo
 * Класс полностью рабочий, осталась парочка мелочей
 * • Нужно доделать сеттеры оставшимся атрибутам: birthDay, birthMonth, birthYear, Country, City
 * • Нужно добавить комментарии ко всем функциям
 * • Нужно нарисовать схему работы класса
 */

namespace app\model;

require_once('CDBConnection.php');

class CUser
{
    const
        TABLE_PREFIX = 'login_',
        USER_TABLE = 'user1';

    private static $_inst;

//<editor-fold defaultstate="collapsed" desc="Атрибуты пользователя">
    /**/
    private $lastName;
    private $firstName;
    private $patroName;
    private $login;
    private $password;
    private $email;
    private $gender;
    private $phone;
    private $question;
    private $answer;
    private $addEmail;
    private $birthDay;
    private $birthMonth;
    private $birthYear;
    private $country;
    private $city;
    private $address;

//</editor-fold>


//<editor-fold defaultstate="collapsed" desc="Основные функции класса">
    /**/
    /**
     * Конструктор класса,
     * @param $userData
     */
    function __construct($userData)
    {
        if ($this->requirment($userData)) {
            $user = CDBConnection::executeQuery('SELECT `login`, `password`
              FROM `' . self::TABLE_PREFIX . self::TABLE . '` WHERE `login` = "' . $this->getLogin() . '"')[0];
            if (isset($user[login])) {
                die("Registration error: Login is exist.");
            }
//            print 'Registration is Correct'; #@debug
        } else {
            echo '<pre>';
            print_r($_FILES[photo]);
            echo '</pre>';
            die ("Registration error: incorrect formdata.");
        }
    }

    /**
     * Здесь определяются объязательные и необъязательные для заполнения поля
     * @param $userData
     * @return bool
     */
    private function requirment($userData)
    {
        // Если в валидации хотя-бы одного поля произошла ошибка,
        // процедура регистрации пользователя прерывается и все поля остаются пустыми
        $req =
            $this->setLastName($userData[lastname]) &&
            $this->setFirstName($userData[firstname]) &&
            $this->setPatroName($userData[patroname]) &&
            $this->setBirthYear($userData[birthYear]) &&
            $this->setBirthMonth($userData[birthMonth]) &&
            $this->setBirthDay($userData[birthDay]) &&
            $this->setGender($userData[gender]) &&
            $this->setLogin($userData[login]) &&
            $this->setPassword($userData[password], $userData[passwordConfirm]) &&
            $this->setEmail($userData[email], $userData[emailConfirm]) &&
            $this->setCountry($userData[country]) &&
            $this->setCity($userData[city]) &&
            $this->setAddress($userData[address]) &&
            TRUE;
        // Эти поля необязательны. Если введенные значения валидны, они записываются, иначе игнорируются
        $unreq =
            $this->setAddEmail($userData[additionalEmail], $userData[additionalEmailConfirm]) ||
            $this->setQuestion($userData[question]) ||
            $this->setAnswer($userData[answer]) ||
            $this->setPhone($userData[phone]) ||
            FALSE;

        return $req;
    }

    /**
     * Получить информацию о пользователе
     * @param   $login  Логин пользователя
     * @return  Возвращает всю имеющуюся информацию о пользователе или false, если пользователь не найден
     */
    public static function getUser($login)
    {
        $res = CDBConnection::executeQuery('SELECT * FROM `user1` WHERE `login` = "' . $login . '"')[0];

        $user[lastname] = $res[lastname];
        $user[firstname] = $res[firstname];
        $user[patroname] = $res[patroname];
        $user[login] = $res[login];
        $user[password] = $res[password];
        $user[email] = $res[email];
        $user[gender] = $res[gender];
        $user[question] = $res[question];
        $user[answer] = $res[answer];

        return new self($user);
    }

    /**
     * Создает нового пользователя
     * @return  boolean Возвращает true если пользователь создан и false если нет
     */
    public function createUser()
    {
        CDBConnection::executeQuery("
             INSERT INTO `user1`
                (`lastname`,
                 `firstname`,
                 `patroname`,
                 `login`,
                 `password`,
                 `email`,
                 `gender`,
                 `phone`,
                 `question`,
                 `asnwer`,
                 `add_email`,
                 `birthday`,
                 `country`,
                 `city`,
                 `address`
                 )
                 VALUES
                 ('"
            . $this->lastName
            . "', '" . $this->firstName
            . "', '" . $this->patroName
            . "', '" . $this->login
            . "', '" . $this->password
            . "', '" . $this->email
            . "', '" . $this->gender
            . "', '" . $this->phone
            . "', '" . $this->question
            . "', '" . $this->answer
            . "', '" . $this->addEmail
            . "', '" . (int)$this->birthYear
            . '-' . (int)$this->birthMonth
            . '-' . (int)$this->birthDay
            . "', '" . $this->country
            . "', '" . $this->city
            . "', '" . $this->address
            . "')
            "
        );
        $this->uploadPhoto();
    }

    public static function authentication($authenticationData)
    {
        $user = CDBConnection::executeQuery('SELECT * FROM `' . self:: . 'user1` WHERE `login` = "' . $authenticationData[login] . '"')[0];
        $validatingPassword = substr(md5($authenticationData[password]), 0, 15);
        if ($user[password] === $validatingPassword) return [true, $user];
        return [false, $user];
    }

    public static function registration($registrationData)
    {
        self::$_inst = new self($registrationData);
        self::$_inst->createUser();
        return self::$_inst;
    }


    /**
     * Удаляет пользователя
     * @param $login
     * @return boolean Возвращает TRUE, если удаление прошло успешно и FALSE если удаления не произошло
     */
    public function deleteUser($login)
    {
    }

    public function uploadPhoto()
    {
        $uploadPhoto = $_FILES[photo];
        if (is_uploaded_file($uploadPhoto[tmp_name])) {
            move_uploaded_file($uploadPhoto[tmp_name], './data/users/photo/' . $this->getLogin() . '.jpg');
        }
    }

//</editor-fold>


//<editor-fold defaultstate="collapsed" desc="Геттеры и Сеттеры">
    /**/
    /**
     * Получить значение "Фамилия" пользователя
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Усановить значение "Фамилия", при условии корректности передаваемого значения
     * @param $lastName
     * @return bool Возвращает TRUE, если валидация прошла удачно иначе возвращает FALSE
     */
    public function setLastName($lastName)
    {
        if ($this->validateFio($lastName)) {
            $this->lastName = $lastName;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Получить значение "Имя" пользователя
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Усановить значение "Имя", при условии корректности передаваемого значения
     * @param $firstname
     * @return bool
     */
    public function setFirstName($firstName)
    {
        if ($this->validateFio($firstName)) {
            $this->firstName = $firstName;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Получить значение "Отчество" пользователя
     * @return mixed
     */
    public function getPatroName()
    {
        return $this->patroName;
    }

    /**
     * Усановить значение "Отчество", при условии корректности передаваемого значения
     * @param $patroName
     * @return bool
     */
    public function setPatroName($patroName)
    {
        if ($this->validateFio($patroName)) {
            $this->patroName = $patroName;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Получить значение "Пол" пользователя
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Усановить значение "Пол", при условии корректности передаваемого значения
     * @param $gender
     * @return bool
     */
    public function setGender($gender)
    {
        if ($this->validateGender($gender)) {
            $this->gender = $gender;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Получить значение "Логин" пользователя
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Усановить значение "Логин", при условии корректности передаваемого значения
     * @param $login
     * @return bool
     */
    public function setLogin($login)
    {
        if ($this->validateLogin($login)) {
            $this->login = $login;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Получить значение "Пароль" пользователя
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Усановить значение "Пароль", при условии корректности передаваемого значения
     * @param $password
     * @param $passwordConfirm
     * @return bool
     */
    public function setPassword($password, $passwordConfirm)
    {
        $pass[password] = $password;
        $pass[passwordConfirm] = $passwordConfirm;
        if ($this->validatePassword($pass)) {
            $this->password = md5($password);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Получить значение "Email" пользователя
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Усановить значение "Email", при условии корректности передаваемого значения
     * @param $email
     * @return bool
     */
    public function setEmail($email, $emailConfirm)
    {
        $em[email] = $email;
        $em[emailConfirm] = $emailConfirm;
//        return FALSE; #@debug
        if ($this->validateEmail($em)) {
            $this->email = $email;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Получить значение "Дополнительный Email" пользователя
     * @return mixed
     */
    public function getAddEmail()
    {
        return $this->addEmail;
    }

    /**
     * Усановить значение "Дополнитльный Email", при условии корректности передаваемого значения
     * @param $addEmail
     * @param $addEmailConfirm
     * @return bool
     */
    public function setAddEmail($addEmail, $addEmailConfirm)
    {
        $em[email] = $addEmail;
        $em[emailConfirm] = $addEmailConfirm;
        if ($this->validateEmail($em)) {
            if ($this->getEmail() !== $addEmail) {
                $this->addEmail = $addEmail;
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Получить значение "Адрес" пользователя
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Усановить значение "Адрес", при условии корректности передаваемого значения
     * @param $address
     * @return bool
     */
    public function setAddress($address)
    {
        if ($this->validateAddress($address)) {
            $this->address = $address;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Получить значение "Ответ" пользователя
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Усановить значение "Ответ", при условии корректности передаваемого значения
     * @param $answer
     * @return bool
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
        return TRUE;
    }

    /**
     * Получить значение "День рождения" пользователя
     * @return mixed
     */
    public function getBirthDay()
    {
        return $this->birthDay;
    }

    /**
     * Усановить значение "День рождения", при условии корректности передаваемого значения
     * @param $birthDay
     * @return bool
     */
    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;
        return TRUE;
    }

    /**
     * Получить значение "Месяц" пользователя
     * @return mixed
     */
    public function getBirthMonth()
    {
        return $this->birthMonth;
    }

    /**
     * Усановить значение "Месяц рождения", при условии корректности передаваемого значения
     * @param $birthMonth
     * @return bool
     */
    public function setBirthMonth($birthMonth)
    {
        $this->birthMonth = $birthMonth;
        return TRUE;
    }

    /**
     * Получить значение "Год рождения" пользователя
     * @return mixed
     */
    public function getBirthYear()
    {
        return $this->birthYear;
    }

    /**
     * Усановить значение "Год рождения", при условии корректности передаваемого значения
     * @param $birthYear
     * @return bool
     */
    public function setBirthYear($birthYear)
    {
        $this->birthYear = $birthYear;
        return TRUE;
    }

    /**
     * Получить значение "Город" пользователя
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Усановить значение "Город", при условии корректности передаваемого значения
     * @param $city
     * @return bool
     */
    public function setCity($city)
    {
        $this->city = $city;
        return TRUE;
    }

    /**
     * Получить значение "Страна" пользователя
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Усановить значение "Страна", при условии корректности передаваемого значения
     * @param $country
     * @return bool
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return TRUE;
    }


    /**
     * Получить значение "Телефон" пользователя
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Усановить значение "Телефон", при условии корректности передаваемого значения
     * @param $phone
     * @return bool
     */
    public function setPhone($phone)
    {
        if ($this->validatePhone($phone)) {
            $this->phone = $phone;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Получить значение "Ответ" пользователя
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Усановить значение "Секретный вопрос", при условии корректности передаваемого значения
     * @param $question
     * @return bool
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return TRUE;
    }

//</editor-fold>


//<editor-fold defaultstate="collapsed" desc="Реализация функций валидации различных атрибутов">
    /**/
    private function validateLogin($validData)
    {
//        return TRUE; #@debug
        if ($validData !== null) {
            if (preg_match('/[^0-9]/', substr($validData, 0, 1))) {
                if (!preg_match('/[^a-z0-9_]/i', $validData)) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /**
     * Валидация для полей Фамилия, Имя и Отчество
     * @param $validData
     * @return bool
     */
    private function validateFio($validData)
    {
        if ($validData !== null && $validData !== '') {
            #@debug Нужно укороротить регулярное выражение, но иначе русские буквы не воспринимает
            if (!preg_match(
                '/[^a-zA-ZйцукенгшщзхъфывапролджэячсмитьбюёЁЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ]/i',
                $validData)
            ) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Валидация пароля пользователем
     * @param $validData Массив значения пароля и значения подтверждения пароля
     * @return bool
     */
    private function validatePassword($validData)
    {
        if ($validData[password] !== '' && $validData[password] !== null &&
            $validData[passwordConfirm] !== '' && $validData[passwordConfirm] !== null
        ) {
            if (strlen($validData[password]) > 6) {
                if ($validData[password] === $validData[passwordConfirm]) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /**
     * Валидация Email введенного пользователем
     * @param $validData
     * @return bool
     */
    private function validateEmail($validData)
    {
        if ($validData[email] !== null && $validData[email] !== '' &&
            $validData[emailConfirm] !== null && $validData[emailConfirm] !== ''
        ) {
            if ($validData[email] === $validData[emailConfirm]) {
                if (filter_var($validData[email], FILTER_VALIDATE_EMAIL)) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /**
     * Валидация пола
     * @param $validData
     * @return bool
     */
    private function validateGender($validData)
    {
        if ($validData !== null) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Валидация телефонного номера
     * @param $validData
     * @return bool
     */
    private function validatePhone($validData)
    {
        if ($validData !== null && $validData !== '') {
            $len = strlen($validData);
            if ($len >= 9 && $len <= 15) {
                if (!preg_match('/[^0-9]/', $validData)) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /**
     * Валидация адреса
     * @param $validData
     * @return bool
     */
    private function validateAddress($validData)
    {
        if ($validData !== null) {
//            if (!preg_match(
//                '/[^a-zA-ZйцукенгшщзхъфывапролджэячсмитьбюёЁЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ0-9, .]/',
//                $validData)
//            ) {
            return TRUE;
//            }
        }
        return FALSE;
    }

//</editor-fold>

}