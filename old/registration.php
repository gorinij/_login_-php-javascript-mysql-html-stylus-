<?php
    /**
     * Created by PhpStorm.
     * User: hardriser
     * Date: 24.08.2015
     * Time: 23:56
     */

    require_once('validation.php');
    require_once('database.php');

    $dbConnection = initDbConnection();

    if (
//        validation('fio', $regData) &&
//        validation('fio', $regData) &&
//        validation('fio', $regData) &&
//        validation('fio', $regData) &&
//        validation('fio', $regData) &&
//        validation('fio', $regData) &&
//        validation('fio', $regData) &&
//        validation('fio', $regData) &&
//        validation('fio', $regData) &&
//        validation('fio', $regData) &&
    1
    ) {
        echo createNewUser($dbConnection, $regData);
    } else {
        $error = 'Введены некорректные данные при заполнении формы!';
    }
    mysqli_close($dbConnection);

    function uploadPhoto($login, $photo) {
        if (
            is_uploaded_file($photo[tmp_name]) &&
            $photo[size] < 1000000 &&
            1
        ) {
            $userfolder = './data/users/photo';
            if (!file_exists($userfolder)) {
                mkdir($userfolder, 0777, TRUE);
            }
            move_uploaded_file($photo[tmp_name], $userfolder . '/' . $login . '.jpg');
        }
    }