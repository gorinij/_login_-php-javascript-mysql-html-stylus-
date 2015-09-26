<?php
/**
 * Created by PhpStorm.
 * User: hardriser
 * Date: 22.08.2015
 * Time: 17:54
 */
namespace login;
session_start();
?>
<?php
use app\model\CLocalization;
use app\model\CUser;

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<?php
$regData = $_POST[regData];
$regData[photo] = $_FILES[photo];
$router = ($_GET[r] !== null) ? $_GET[r] : $_POST[r];

include_once 'models\CUser.php';
include_once 'models\CLocalization.php';

/**
 * Запуск инициализации
 */
new CLocalization();
/*
 * Если мы получаем какое-то значение из формы локализации, присваиваем
 * это значение обычной и сессионной переменной localization.
 * Если же мы ничего не получаем от формы локализации, мы присваиваем
 * переменной localization соответствующее значение из сессионной переменной.
 * Тем самым, у нас имеется постоянно-актуальное значение локализации в
 * течении всей сессии.
 */
if (($_POST[localization]) != null) {
    $localization1 = $_POST[localization];
    $_SESSION[localization] = $localization1;
    if ($localization1 == CLocalization::LOCALE_RU)
        $locale = CLocalization::localizateAllFields(CLocalization::LOCALE_RU);
    else if ($localization1 == CLocalization::LOCALE_EN)
        $locale = CLocalization::localizateAllFields(CLocalization::LOCALE_EN);
} else {
    $localization1 = $_SESSION[localization];
    if ($localization1 == CLocalization::LOCALE_RU)
        $locale = CLocalization::localizateAllFields(CLocalization::LOCALE_RU);
    else if ($localization1 == CLocalization::LOCALE_EN)
        $locale = CLocalization::localizateAllFields(CLocalization::LOCALE_EN);
}
?>
<?php
?>
<?php //require_once('localization.php'); ?>
<body>
<div id="content">
    <div class="wrapper inner content">
        <?php
        /**
         * Скрипт маршрутизации
         */
        switch ($router) {
            case 'signin':
                include_once('views\signin.php');
                break;
            case 'signup':
                include_once('views\signup.php');
                break;
            case 'regist':
                $user = CUser::registration($regData);
                include_once('views\userprofile.php');
                break;
            case 'auth':
                $user = CUser::authentication($regData);
                /**
                 * Если аутентификация пройдена успешно,
                 * то в вюшку userprofile передаем
                 * информацию о пользователе, которое оно и выведет.
                 * В противном случае, передаем false, оно
                 * сообщит об ошибке аутентификации.
                 */
                if ($user[0]) {
                    $regData = $user[1];
                    include_once('views\userprofile.php');
                } else {
                    $regData = false;
                    include_once('views\userprofile.php');
                }
                break;
            default:
                include_once('views\signin.php');
                break;
        }

        ?>
    </div>
</div>
</body>
<script>
    <?php
    /**
     *  Локализовынне значения для JS текстов
     */
        if ($error) {
            print("alert('" . $error . "')");
        }
        print('
        var localization = {
            uploadPhoto: "'. $locale[uploadPhoto] .'",
            photoUpload: "'. $locale[photoUpload] .'",

            validPasswordNull: "'. $locale['validPasswordNull'] .'",
            validPasswordNEqual: "'. $locale['validPasswordNEqual'] .'",
            validPhoneRange: "'. $locale['validPhoneRange'] .'",
            validPhoneOnlyDig: "'. $locale['validPhoneOnlyDig'] .'",
            validLoginNDig: "'. $locale['validLoginNDig'] .'",
            validLoginABC: "'. $locale['validLoginABC'] .'",
            validLoginNABC: "'. $locale['validLoginNABC'] .'",
            validPasswordShort: "'. $locale['validPasswordShort'] .'",
            validLastnameABC: "'. $locale['validLastnameABC'] .'",
            validFirstnameABC: "'. $locale['validFirstnameABC'] .'",
            validPatronameABC: "'. $locale['validPatronameABC'] .'",
            validInvalEmailFormat: "'. $locale['validInvalEmailFormat'] .'",
            validEmailNEqual: "'. $locale['validEmailNEqual'] .'",
            validEmailMainAndAddEqual: "'. $locale['validEmailMainAndAddEqual'] .'",
            cityMsk: "'. $locale[cityMsk] .'",
            cityWsh: "'. $locale[cityWsh] .'",
            cityPrs: "'. $locale[cityPrs] .'",
            cityTky: "'. $locale[cityTky] .'",
            cityNyk: "'. $locale[cityNyk] .'",
            cityMrs: "'. $locale[cityMrs] .'",
            citySpb: "'. $locale[citySpb] .'",
            cityBrl: "'. $locale[cityBrl] .'",
            cityRam: "'. $locale[cityRam] .'",
            cityKyo: "'. $locale[cityKyo] .'"
        };
        ');
    ?>
</script>
<script src="script.js"></script>
</html>