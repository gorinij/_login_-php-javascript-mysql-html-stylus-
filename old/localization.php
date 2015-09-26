<?php
    /**
     * Created by PhpStorm.
     * User: hardriser
     * Date: 24.08.2015
     * Time: 23:47
     */
    $localization = ($_GET[localization]) ?: 'ru';
    function loc($loc, $str) {
        if ($loc === 'ru') {
            switch ($str) {
                case 'lastname':
                    return 'Фамилия';
                case 'firstname':
                    return 'Имя';
                case 'patroname':
                    return 'Отчество';
                case 'login':
                    return 'Логин';
                case 'password':
                    return 'Пароль';
                case 'passwordConfirm':
                    return 'Подтверждение пароля';
                case 'email':
                    return 'Введите Email';
                case 'confirmEmail':
                    return "Подтвердите ваш Email";
                case 'gender':
                    return 'Пол';
                case 'gender_men':
                    return 'Мужчина';
                case 'gender_women':
                    return 'Женщина';
                case 'phone':
                    return 'Номер телефона';
                case 'secretQuestion':
                    return 'Секретный вопрос';
                case 'answer':
                    return 'Ответ';
                case 'additionalEmail':
                    return "Запасной Email";
                case 'confirmAdditionalEmail':
                    return "Подтвердите запасной Email";
                case 'birthday':
                    return 'Дата рождения';
                case 'birthDay':
                    return 'День';
                case 'birthMonth':
                    return 'Месяц';
                case 'birthYear':
                    return 'Год';
                case 'place':
                    return 'Месторасположение';
                case 'place_country_ru':
                    return 'Россия';
                case 'place_country_fr':
                    return 'Франция';
                case 'place_country_jp':
                    return 'Япония';
                case 'place_country_gr':
                    return 'Германия';
                case 'place_country_us':
                    return 'США';
                case 'place_city_msc':
                    return 'Москва';
                case 'place_city_brl':
                    return 'Берлин';
                case 'place_city_wsh':
                    return 'Вашингтон';
                case 'place_city_tky':
                    return 'Токио';
                case 'place_city_mrs':
                    return 'Марсель';
                case 'place_address':
                    return 'Улица, дом, квартира';
                case 'registration':
                    return 'Регистрация';
                case 'chooseLanguage':
                    return 'Язык';
                case 'whatIsYourName':
                    return 'Как вас зовут';
                case 'genderAndDate':
                    return 'Укажите ваш пол и дату вашего рождения';
                case 'loginPasswordQuestion':
                    return 'Придумайте имя пользователя, пароль и секретный вопрос';
                case 'enterYourEmail':
                    return 'Введите ваш основной и дополнительный Email';
                case 'contactData':
                    return 'Введите ваш номер телефона и адрес места проживания';
                case 'birthMonth_jan':
                    return 'Январь';
                case 'birthMonth_feb':
                    return 'Февраль';
                case 'birthMonth_mar':
                    return 'Март';
                case 'birthMonth_apr':
                    return 'Апрель';
                case 'birthMonth_may':
                    return 'Май';
                case 'birthMonth_jun':
                    return 'Июнь';
                case 'birthMonth_jul':
                    return 'Июль';
                case 'birthMonth_aug':
                    return 'Август';
                case 'birthMonth_sep':
                    return 'Сентябрь';
                case 'birthMonth_okt':
                    return 'Октябрь';
                case 'birthMonth_nov':
                    return 'Ноябрь';
                case 'birthMonth_dec':
                    return 'Декабрь';
                case 'uploadPhoto':
                    return "Загрузить фотографию";
                case 'photoUpload':
                    return "Фотография загружена";
            }
        } else if ($loc === 'en') {
            switch ($str) {
                case 'lastname':
                    return 'Lastname';
                case 'firstname':
                    return 'Firstname';
                case 'patroname':
                    return 'Patroname';
                case 'login':
                    return 'Login';
                case 'password':
                    return 'Password';
                case 'passwordConfirm':
                    return 'Confirm the password';
                case 'email':
                    return 'Enter your Email';
                case 'confirmEmail':
                    return "Confirm your Email";
                case 'gender':
                    return 'Gender';
                case 'gender_men':
                    return 'Man';
                case 'gender_women':
                    return 'Woman';
                case 'phone':
                    return 'Phone number';
                case 'secretQuestion':
                    return 'Secret question';
                case 'answer':
                    return 'Answer';
                case 'additionalEmail':
                    return "Additional Email";
                case 'confirmAdditionalEmail':
                    return "Confirm additional Email";
                case 'birthday':
                    return 'Birthday';
                case 'birthDay':
                    return 'Day';
                case 'birthMonth':
                    return 'Month';
                case 'birthYear':
                    return 'Year';
                case 'place':
                    return 'Place';
                case 'place_country_ru':
                    return 'Russia';
                case 'place_country_fr':
                    return 'France';
                case 'place_country_jp':
                    return 'Japan';
                case 'place_country_gr':
                    return 'German';
                case 'place_country_us':
                    return 'USA';
                case 'place_city_msc':
                    return 'Moscow';
                case 'place_city_brl':
                    return 'Berlin';
                case 'place_city_wsh':
                    return 'Washington';
                case 'place_city_tky':
                    return 'Tokyo';
                case 'place_city_mrs':
                    return 'Marsel';
                case 'place_address':
                    return 'Street';
                case 'registration':
                    return 'Registration';
                case 'chooseLanguage':
                    return 'Language';
                case 'whatIsYourName':
                    return 'What is your name';
                case 'genderAndDate':
                    return 'Select your gender and birthday';
                case 'loginPasswordQuestion':
                    return 'Input your login, password and secret question';
                case 'enterYourEmail':
                    return 'Enter your main and additional Email';
                case 'contactData':
                    return 'Enter your phone number and your address';
                case 'birthMonth_jan':
                    return 'January';
                case 'birthMonth_feb':
                    return 'Febrary';
                case 'birthMonth_mar':
                    return 'March';
                case 'birthMonth_apr':
                    return 'April';
                case 'birthMonth_may':
                    return 'May';
                case 'birthMonth_jun':
                    return 'June';
                case 'birthMonth_jul':
                    return 'July';
                case 'birthMonth_aug':
                    return 'August';
                case 'birthMonth_sep':
                    return 'September';
                case 'birthMonth_okt':
                    return 'October';
                case 'birthMonth_nov':
                    return 'November';
                case 'birthMonth_dec':
                    return 'December';
                case 'uploadPhoto':
                    return "Upload photo";
                case 'photoUpload':
                    return "Photo is upload";
            }

        }
    }
