<?php
    /**
     * Created by PhpStorm.
     * User: hardriser
     * Date: 26.08.2015
     * Time: 17:59
     */
?>
<?php

    class Validation
        {
        /**
         * Алгоритм валидации пользователя
         *
         * @param $validationData
         *
         * @return bool|string
         */
            public static function signinValidation($validationData) {
                /*  Алгоримт валидации следующий:
                 *   Получаем информацию о пользователе
                 *   Смотрим есть ли такой в базе
                 *   Если таковая имеется, то валидация успешно завершается
                 *   Затем дополняем алгоритм и сверяем md5 значение введенного пароля с тем который имеется в базе
                 *   Если зашифрованный пароль из базы равен тому же что мы ввели, то валидация проходит успешно
                 */
                require_once('database.php');
                $user = User::getUser($validationData[login]);
                if (empty($user)) {
                    die("Access denied! Login is Wrong");
                }
                if (substr(md5($validationData[password]), 0, 15) !== $user[password]) {
                    die("Access Denied! Password is Wrong");
                }
//            if ($user[password] !== "admin") {
//                die("Acces denied 2");
//            }
                return $user;
            }
        }

    function validation(
        $p,
        $validData
    ) {
        switch ($p) {
            case 'fio':
                return validateFio($validData); //√
            case 'birthday':
                return validateBirthday($validData); //√
            case 'gender':
                return validateGender($validData); //√
            case 'login':
                return validateLogin($validData); //√
            case 'password':
                return validatePassword($validData); //√
            case 'question':
                return validateQuestion($validData); //√
            case 'email':
                return validateEmail($validData); //√
            case 'additionalEmail':
                return validateAdditionalEmail($validData); //√
            case 'phone':
                return validatePhone($validData); //√
            case '*':
                return (
                    validateFio($validData) &&
                    validateBirthday($validData) &&
                    validateGender($validData) &&
                    validateLogin($validData) &&
                    validatePassword($validData) &&
                    validateQuestion($validData) &&
                    validateEmail($validData) &&
                    validateAdditionalEmail($validData) &&
                    validatePhone($validData) &&
                    1
                );
            default:
                return FALSE; //√
        }
    }

    function validateLogin($validData) {
        if ($validData['login']) {
            if (validationRegExp('specialChars', $validData[login])) {
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }

    function validateFio($validData) {
        if (
            $validData['lastname'] && $validData['firstname'] && $validData['patroname']
        ) {
            if (
//                validationRegExp('specialChars', $validData['lastname']) &&
//                validationRegExp('specialChars', $validData['firstname']) &&
//                validationRegExp('specialChars', $validData['patroname']) &&
                validationRegExp('numbers', $validData['lastname']) &&
                //                validationRegExp('numbers', $validData['firstname']) &&
                //                validationRegExp('numbers', $validData['patroname']) &&
                1
            ) {
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }

    function validateBirthday($validData) {
        if (
            filter_var($validData[birthDay], FILTER_VALIDATE_INT) &&
            filter_var($validData[birthMonth], FILTER_VALIDATE_INT) &&
            filter_var($validData[birthYear], FILTER_VALIDATE_INT) &&
            1
        ) {
            if (
                (int)$validData['birthDay'] <= 31 && (int)$validData['birthDay'] > 0 &&
                (int)$validData['birthMonth'] <= 12 && (int)$validData['birthMonth'] > 0 &&
                (int)$validData['birthYear'] >= 1940 && (int)$validData['birthYear'] <= 2015 &&
                1
            ) {
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }

    function validateGender($validData) {
        if (
            (int)$validData['gender'] === 1 ||
            (int)$validData['gender'] === 0
        ) {
            return TRUE;
        }
        return FALSE;
    }

    function validateQuestion($validData) {
        if (
            (boolean)$validData[secretQuestion] &&
            (boolean)$validData[answer] &&
            1
        ) {
            return TRUE;
        }
        return FALSE;
    }

    function validatePhone($validData) {
        if (
            (boolean)$validData[phone] &&
            1
        ) {
            return TRUE;
        }
        return FALSE;
    }

    function validateAdditionalEmail($validData) {
        if (($validData['additionalEmail'] === $validData['additionalEmailConfirm'])) {
            if (filter_var($validData['additionalEmail'], FILTER_VALIDATE_EMAIL)) {
                return TRUE;
            }
            return FALSE;
        } else {
            return FALSE;
        }
    }

    function validateEmail($validData) {
        return ($validData['email'] === $validData['emailConfirm']);
    }

    function validatePassword($validData) {
        return ($validData['password'] === $validData['passwordConfirm']);
    }

    function validationRegExp($p, $v) {
        switch ($p) {
            case 'specialChars':
// @issue   При вводе букв и спецсимволов, не распознает
//                return preg_match('/[^\!~@#$%^&:;`*(|){}\[\]]/', $v);
                return TRUE; //@debug
            case 'numbers':
// @issue   При вводе букв и цифр, не распознает
                return preg_match('/a|b/', $v);
            default:
                return 0;
        }
    }

    function validationIsNumber($d) {

    }