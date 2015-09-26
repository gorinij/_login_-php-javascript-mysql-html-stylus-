<?php
/**
 * Created by PhpStorm.
 * User: hardriser
 * Date: 31.08.2015
 * Time: 19:49
 */
?>
<div id="signup">
<div class="wrapper form localization">
    <form id="localization" method="post" action="">
        <select name="localization">
            <option value="0">Русский</option>
            <option value="1">English</option>
        </select>
        <input value="<?= $locale[chooseLanguage] ?>" type="submit"/>
    </form>
</div>
<div class="wrapper form signup">
<form
    method="post"
    action="../index.php"
    id="registrationForm"
    enctype="multipart/form-data"
    >
<input type="hidden" name="r" value="regist"/>
<input name="form" type="hidden" value="signup"/>

<h2><?= $locale[registration] ?></h2>
<input
    name="registration"
    value="1"
    type="hidden"
    />

<ul class="nonStyle">
<li><h4><?= $locale[whatIsYourName] ?></h4></li>
<li>
    <input
        id="lastname"
        name="regData[lastname]"
        placeholder="<?= $locale[lastname] ?>"
        type="text"
        <?php if ($_POST[regData][lastname] !== '') {
            printf('value=' . $_POST[regData][lastname]);
        } ?>
        />
</li>
<li>
    <div id="lastname_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li>
    <input
        id="firstname"
        name="regData[firstname]"
        placeholder="<?= $locale[firstname] ?>"
        type="text"
        <?php if ($_POST[regData][firstname] !== '') {
            printf('value=' . $_POST[regData][firstname]);
        } ?>
        />
</li>
<li>
    <div id="firstname_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li>
    <input
        id="patroname"
        name="regData[patroname]"
        placeholder="<?= $locale[patroname] ?>"
        type="text"
        <?php if ($_POST[regData][patroname] !== '') {
            printf('value=' . $_POST[regData][patroname]);
        } ?>
        />
</li>
<li>
    <div id="patroname_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li>
    <label>
        <div id="photoUploadButton"><?= $locale[uploadPhoto] ?></div>
        <input
            id="photo"
            type="file"
            name="photo"
            style="display: none"
            accept="image/jpeg, image/jpg"
            />
        <img id="photoPreview" src="" alt=""/>
    </label>
</li>
<li><h4><?= $locale[genderAndDate] ?></h4></li>
<li>
    <?= $locale[birthday] ?>:<br/>
    <input
        id="birthDay"
        class="birthday"
        name="regData[birthDay]"
        placeholder="<?= $locale[birthDay] ?>"
        type="number"
        value="1"
        />
    <select
        id="birthMonth"
        class="birthday"
        name="regData[birthMonth]"
        placeholder="<?= $locale[birthMonth] ?>"
        >
        <option value="1"><?= $locale[birthMonth_jan] ?></option>
        <option value="2"><?= $locale[birthMonth_feb] ?></option>
        <option value="3"><?= $locale[birthMonth_mar] ?></option>
        <option value="4"><?= $locale[birthMonth_apr] ?></option>
        <option value="5"><?= $locale[birthMonth_may] ?></option>
        <option value="6"><?= $locale[birthMonth_jun] ?></option>
        <option value="7"><?= $locale[birthMonth_jul] ?></option>
        <option value="8"><?= $locale[birthMonth_aug] ?></option>
        <option value="9"><?= $locale[birthMonth_sep] ?></option>
        <option value="10"><?= $locale[birthMonth_okt] ?></option>
        <option value="11"><?= $locale[birthMonth_nov] ?></option>
        <option value="12"><?= $locale[birthMonth_dec] ?></option>
    </select>
    <input
        id="birthYear"
        class="birthday"
        name="regData[birthYear]"
        placeholder="<?= $locale[birthYear] ?>"
        type="number"
        value="2015"
        />
</li>
<li>
    <?= $locale[gender] ?>:<br/>
    <label>
        <input
            name="regData[gender]"
            value="1"
            type="radio"
            checked
            />
        <?= $locale[gender_man] ?>
    </label>
    <label>
        <input
            value="0"
            name="regData[gender]"
            type="radio"/><?= $locale[gender_woman] ?>
    </label>
</li>
<li><h4><?= $locale[loginPasswordQuestion] ?></h4></li>
<li>
    <input
        id="login"
        name="regData[login]"
        placeholder="<?= $locale[login] ?>"
        type="text"
        />
</li>
<li>
    <div id="login_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li>
    <input
        id="password"
        name="regData[password]"
        placeholder="<?= $locale[password] ?>"
        type="password"
        value=""
        />
</li>
<li>
    <div id="password_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li>
    <input
        id="passwordConfirm"
        name="regData[passwordConfirm]"
        placeholder="<?= $locale[passwordConfirm] ?>"
        type="password"
        id="passwordConfirm"
        value=""/>
</li>
<li>
    <div id="passwordConfirm_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li>
    <input
        name="regData[question]"
        text="text"
        placeholder="<?= $locale[question] ?>"
        type="text"/>
</li>
<li>
    <input
        name="regData[answer]"
        text="text"
        placeholder="<?= $locale[answer] ?>"
        type="text"
        />
</li>
<li><h4><?= $locale[enterYourEmail] ?></h4></li>
<li>
    <input
        id="email"
        name="regData[email]"
        placeholder="<?= $locale[email] ?>"
        type="text"/>
</li>
<li>
    <div id="email_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li>
    <input
        id="emailConfirm"
        name="regData[emailConfirm]"
        placeholder="<?= $locale[emailConfirm] ?>"
        type="text"
        />
</li>
<li>
    <div id="emailConfirm_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li>
    <input
        name="regData[additionalEmail]"
        text="text"
        id="additionalEmail"
        placeholder="<?= $locale[addEmail] ?>"
        type="text"
        />
</li>
<li>
    <div id="additionalEmail_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li>
    <input
        name="regData[additionalEmailConfirm]"
        text="text"
        id="additionalEmailConfirm"
        placeholder="<?= $locale[addEmailConfirm] ?>"
        type="text"
        />
</li>
<li>
    <div id="additionalEmailConfirm_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li><h4><?= $locale[contactData] ?></h4></li>
<li>
    <input
        id="phone"
        name="regData[phone]"
        placeholder="<?= $locale[phone] ?>"
        type="text"
        />
</li>
<li>
    <div id="phone_error_content" class="validation_error_content">ошибка валидации</div>
</li>
<li>
    <?= $locale[place] ?>:<br/>
    <select name="regData[country]" id="country">
        <option selected disabled style="display: none"><?= $locale[chooseCountry] ?></option>
        <option value="ru">
            <?= $locale[place_country_ru] ?>
        </option>
        <option value="fr">
            <?= $locale[place_country_fr] ?>
        </option>
        <option value="de">
            <?= $locale[place_country_gr] ?>
        </option>
        <option value="jp">
            <?= $locale[place_country_jp] ?>
        </option>
        <option value="us">
            <?= $locale[place_country_us] ?>
        </option>
    </select>
    <select name="regData[city]" id="city">
        <option selected disabled><?= $locale[chooseCity] ?></option>
        <!--        <option value="msc">-->
        <!--            --><? //= $locale[place_city_msc] ?>
        <!--        </option>-->
        <!--        <option value="brl">-->
        <!--            --><? //= $locale[place_city_brl] ?>
        <!--        </option>-->
        <!--        <option value="wsh">-->
        <!--            --><? //= $locale[place_city_wsh] ?>
        <!--        </option>-->
        <!--        <option value="tky">-->
        <!--            --><? //= $locale[place_city_tky] ?>
        <!--        </option>-->
        <!--        <option value="mrs">-->
        <!--            --><? //= $locale[place_city_mrs] ?>
        <!--        </option>-->
    </select>
    <input
        name="regData[address]"
        type="text"
        placeholder="<?= $locale[place_address] ?>"
        />
</li>
<li>
    <div id="address_error_content" class="validation_error_content">ошибка валидации</div>
</li>
</ul>
<input
    type="submit"
    value="<?= $locale[registration] ?>"
    />
</form>
</div>
</div>