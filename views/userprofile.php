<?php
/**
 * Created by PhpStorm.
 * User: hardriser
 * Date: 31.08.2015
 * Time: 19:51
 */

/**
 * Возвращает текстовое название пола по его идентификатору
 * @param $gender Числовой идентификатор пола, где 0 - женщина, 1 - мужчина
 * @return string Название пола
 */
function getGender($gender)
{
    global $locale;
    switch ($gender) {
        case 0:
            return $locale[gender_woman];
        case 1:
            return $locale[gender_man];
    }
}

/**
 * Получить названия стран и городов
 * @param $addrType Принимает значения 'country' или 'city' для страны и города соответственно
 * @param $a Идинтификатор страны или города
 * @return string Возвращает название страны
 */
function getAddress($addrType, $a)
{
    global $locale;
    switch ($addrType) {
        case 'country':
            switch ($a) {
                case 'ru':
                    return ($locale[place_country_ru]);
            }
            break;
        case 'city':
            switch ($a) {
                case 'msc':
                    return $locale[place_city_msc];
            }
            break;
    }
}

?>
<div id="user">
    <!--    <div class="wrapper form localization">-->
    <!--        <form method="post" action="">-->
    <!--            <select name="localization" id="">-->
    <!--                <option value="0">Русский</option>-->
    <!--                <option value="1">English</option>-->
    <!--            </select>-->
    <!--            <input value="--><? //= $locale[chooseLanguage] ?><!--" type="submit"/>-->
    <!--        </form>-->
    <!--    </div>-->

    <div class="wrapper inner">
        <?php
        /**
         * После аутентификации, в переменную $regData передается либо данные пользователя, либо значение false.
         * Если там данные пользователя, то отображается его профиль.
         * Если стоит значение false, выводим сообщение об ошибке авлидации
         * @link index.php
         */
        if ($regData) :
            if ($_POST[form] === 'signin') {
                $welcomeTitle = $locale[signinSuccess];
            } else if ($_POST[form] === 'signup') {
                $welcomeTitle = $locale[signupSuccess];
            }
            ?>
            <h2>
                <?= $regData[login]; ?>
            </h2>
            <img id="user_photo" src=<?= './data/users/photo/' . $regData[login] . '.jpg' ?>
            alt="" height="100" style="float: right; margin-top: -30px;"/>
            <h5 id="welcomeTitle"><?= $welcomeTitle; ?></h5>
            <dl>
                <dt><?= $locale[bio] ?></dt>
                <dd>
                    <ul class="nonStyle">
                        <?php if ($regData[lastname] != null || $regData[lastname] != '') : ?>
                            <li>
                                <label><?= $locale[lastname] ?>: <?= $regData[lastname] ?></label>
                            </li>
                        <?php endif; ?>
                        <?php if ($regData[firstname] != null || $regData[firstname] != '') : ?>
                            <li>
                                <label><?= $locale[firstname] ?>: <?= $regData[firstname] ?></label>
                            </li>
                        <?php endif; ?>
                        <?php if ($regData[patroname] != null || $regData[patroname] != '') : ?>
                            <li>
                                <label><?= $locale[patroname] ?>: <?= $regData[patroname] ?></label>
                            </li>
                        <?php endif; //print_r($regData); ?>
                        <?php
                        if ($regData[birthday] != '' || $regData[birthday] != '') {
                            $regData[birthDay] = substr($regData[birthday], 9, 1);
                            $regData[birthMonth] = substr($regData[birthday], 6, 1);
                            $regData[birthYear] = substr($regData[birthday], 0, 4);
                        }
                        ?>
                        <?php if ($regData[birthDay] != null || $regData[birthDay] != '') : ?>
                            <?php
                            if ($regData[birthDay] < 10) $regData[birthDay] = '0' . $regData[birthDay];
                            if ($regData[birthMonth] < 10) $regData[birthMonth] = '0' . $regData[birthMonth];
                            ?>
                        <?php endif; ?>
                        <li>
                            <label>Дата рождения: <?=
                                $regData[birthDay] . '.' .
                                $regData[birthMonth] . '.' .
                                $regData[birthYear] ?>
                            </label>
                        </li>
                        <?php if ($regData[gender] != null || $regData[gender] != '') : ?>
                            <li>
                                <label><?= $locale[gender]; ?>: <?= getGender($regData[gender]) ?></label>
                            </li>
                        <?php endif; ?>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><?= $locale[contactData] ?></dt>
                <dd>
                    <ul class="nonStyle">
                        <?php if ($regData[email] != null || $regData[email] != '') : ?>
                            <li>
                                <label><?= $locale[mainEmail] ?>: <?= $regData[email] ?></label>
                            </li>
                        <?php endif; ?>
                        <?php if ($regData[add_email] != null || $regData[add_email] != '') : ?>
                            <li>
                                <label><?= $locale[additEmail] ?>: <?= $regData[add_email] ?></label>
                            </li>
                        <?php endif; ?>
                        <?php if ($regData[phone] != null || $regData[phone] != '') : ?>
                            <li>
                                <label><?= $locale[phone] ?>: <?= $regData[phone] ?></label>
                            </li>
                        <?php endif; ?>
                        <?php if ($regData[country] != null || $regData[country] != '') : ?>
                            <li>
                                <label><?= $locale[livePlace] ?>:
                                    <?= getAddress('country', $regData[country]); ?><?php if ($regData[city] != null || $regData[city] != '') {
                                        echo(', ' . getAddress('city', $regData[city]));
                                        if ($regData[address] != null || $regData[address] != '') {
                                            echo ', ' . $regData[address];
                                        }
                                    }
                                    ?>
                                </label>
                            </li>
                        <?php endif; ?>
                    </ul>
                </dd>
            </dl>
        <?php
        else :
            print "<h2 style='color:red'> $locale[authError] </h2>";
        endif;
        ?>
    </div>
</div>
