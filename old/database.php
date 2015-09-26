<?php
    /**
     * Created by PhpStorm.
     * User: hardriser
     * Date: 30.08.2015
     * Time: 20:32
     */
?>



<?php

    class User
        {
        /**
         * Возвращает данные юзера из БД по его имени
         *
         * @param $username
         *
         * @return array
         */
            public static function getUser($username) {
                $dbConnection = initDbConnection();
                if (mysql_errno() === 0) {
                    die("DbConnection error");
                }
                $dbResult = mysqli_query($dbConnection, "SELECT * FROM `user1` WHERE `login` = '" . $username . "'");
                $dbResult = mysqli_fetch_assoc($dbResult);
                return $dbResult;
            }
        }

    function initDbConnection() {
        return mysqli_connect('localhost', 'root', '', 'test_login');
    }

    function initUser($dbConnection) {
        $db_query_init_user =
            'CREATE TABLE `user1` (
             `id` INT PRIMARY KEY AUTO_INCREMENT,
             `lastname` VARCHAR (50),
             `firstname` VARCHAR (50),
             `patroname` VARCHAR (50),
             `login` VARCHAR (15),
             `password` VARCHAR (15),
             `email` VARCHAR (50),
             `gender` SMALLINT,
             `phone` VARCHAR (25),
             `question` VARCHAR (250),
             `answer` VARCHAR (50),
             `add_email` VARCHAR (50),
             `birthday` TIMESTAMP,
             `country` VARCHAR (15),
             `city` VARCHAR (15),
             `address` VARCHAR (50)
            );';

        mysqli_query($dbConnection, $db_query_init_user);
    }

    function createNewUser($dbConnection, $regData) {
        if (mysqli_errno($dbConnection) === 0) {
            $db_query = "
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
                        . $regData[lastname]
                        . "', '" . $regData[firstname]
                        . "', '" . $regData[patroname]
                        . "', '" . $regData[login]
                        . "', '" . md5($regData[password])
                        . "', '" . $regData[email]
                        . "', '" . $regData[gender]
                        . "', '" . $regData[phone]
                        . "', '" . $regData[secretQuestion]
                        . "', '" . $regData[answer]
                        . "', '" . $regData[additionalEmail]
                        . "', '" . (int)$regData[birthYear]
                        . '-' . (int)$regData[birthMonth]
                        . '-' . (int)$regData[birthDay]
                        . "', '" . $regData[country]
                        . "', '" . $regData[city]
                        . "', '" . $regData[address]
                        . "')
            ";
            mysqli_query($dbConnection, $db_query);
            return mysqli_error($dbConnection);
        } else {
            return 'Произошла ошибка при подключении к БД';
        }
    }

?>