/**
 * Created by hardriser on 24.08.2015.
 */
var
// Создаем простые метод для отладки
    echoL = function (msg) {
        console.log(msg);
    },
    echoA = function (msg) {
        window.alert(msg);
    };
// Заворачиваем скрипт приложения в пространство имен App, чтобы ограничить замусоривание глобального пространства
App = {
    registrationForm: document.forms['registrationForm'],
    authorizationForm: document.forms['authorizationForm'],
    script: function () {
        Date.prototype.daysInMonth = function (y, m) {
            return 32 - new Date(y, m, 32).getDate();
        };

        function isUndef(el) {
            return el === undefined;
        }

        function Validation(validate) {
            switch (validate) {
                case 'password':
                    return registrationForm['password'].value === registrationForm['passwordConfirm'].value;
                case 'email':
                    return registrationForm['email'].value === registrationForm['emailConfirm'].value;
                case 'additionalEmail':
                    return registrationForm['additionalEmail'].value === registrationForm['additionalEmailConfirm'].value;
                default:
                    return 'test';
            }
        }

        /**
         * Проверка на корректность даты рождения
         */
        var validateBirthday = function () {
            var
                date = new Date();
            /**
             * Если год, месяц и день находятся за пределами допустимого предела диапозона
             * то выстовляем им максимально или минимально разрешенные значения
             * в зависимости от того в какую сторону указывает неправильное значение
             */
            if (
                registrationForm['birthYear'].value <= date.getFullYear() &&
                registrationForm['birthYear'].value >= 1915 &&
                registrationForm['birthMonth'].value <= 12 &&
                registrationForm['birthMonth'].value >= 1 &&
                registrationForm['birthDay'].value <= 31 &&
                registrationForm['birthDay'].value >= 1 &&
                1
            ) {
            } else {
                if (registrationForm['birthYear'].value > date.getFullYear()) {
                    registrationForm['birthYear'].value = date.getFullYear();
                } else if (registrationForm['birthYear'].value < 1915) {
                    registrationForm['birthYear'].value = 1915;
                }
                if (registrationForm['birthMonth'].value > 12) {
                    registrationForm['birthMonth'].value = 12;
                } else if (registrationForm['birthMonth'].value < 1) {
                    registrationForm['birthMonth'].value = 1;
                }
                if (registrationForm['birthDay'].value > 31) {
                    registrationForm['birthDay'].value = 31;
                } else if (registrationForm['birthDay'].value < 1) {
                    registrationForm['birthDay'].value = 1;
                }

            }
        };

        /**
         * Проверка на корректность даты тождения
         */
        var validatePassword = function () {
            validateField(true, 'password');
            /**
             * Пароль не должен быть пустым, его длина не может быть меньше шести символов
             * И поля пароля и подтверждения пароля должны быть одинаковыми
             */
            if (registrationForm['password'].value.length !== 0) {
                if (registrationForm['password'].value.length < 6) {
                    validateField(false, 'password', localization['validPasswordNull']);
                } else if (registrationForm['password'].value !== registrationForm['passwordConfirm'].value) {
                    validateField(false, 'passwordConfirm', localization['validPasswordNEqual']);
                } else {
                    validateField(true, 'passwordConfirm');
                }
            } else {
                //validateField(false, 'password', "Пароль не должен оставаться пустым");
            }
        };

        /**
         * Проверка на корректность номера телефона
         */
        var validatePhone = function () {
            var expr = /[^0-9]/;
            validateField(true, 'phone');
            /**
             * Номер количество цифр в номере телефона должно
             * находиться в пределах определенного диапозона.
             * В качестве номера телефона могут быть только цыфровые символы
             */
            if (registrationForm['phone'].value.length !== 0 &&
                registrationForm['phone'].value.length <= 9 ||
                registrationForm['phone'].value.length >= 17) {
                validateField(false, 'phone', localization['validPhoneRange']);
            }
            // в телефонном номере записано нецифровое значение
            if (registrationForm['phone'].value.match(expr)) {
                validateField(false, 'phone', localization['validPhoneOnlyDig']);
            }
        };

        function rangeValidation(elem, msg) {
            // количество символов не находится в соответствующем для телефонного номера диапозоне
            if (
                registrationForm[elem].value.length < 9 ||
                registrationForm[msg].value.length > 15
            ) {
                echoA(msg);
            }
        }

        function numberValidation(elem, msg) {
            // в телефонном номере записано нецифровое значение
            var expr = /[^0-9]/;
            if (
                registrationForm[elem].value.match(expr)
            ) {
                echoA(msg);
            }
        }

        /**
         * Изменяет надпись на кнопке загрузки изображения.
         * Если загружаемое изображение назначено, отображается одна надпись
         * Если не отображается другое
         */
        function fileSelectEvent() {
            if (registrationForm['photo'].value) {
                document.getElementById("photoUploadButton").innerHTML = localization['photoUpload'];
                //echoA("!" + localization['photoUpload']);   //@debug
            } else {
                document.getElementById("photoUploadButton").innerHTML = localization['uploadPhoto'];
                //echoA("!" + localization['uploadPhoto']);   //@debug
            }
        }

        //function validateEmail() {
        //    if (registrationForm['email'].value !== '' && registrationForm['additionalEmail'].value !== '') {
        //        if (registrationForm['email'].value === registrationForm['additionalEmail'].value) {
        //            echoA("Введите другой адрес в качестве дополнительного Email");
        //        }
        //        if (registrationForm['email'].value !== registrationForm['emailConfirm'].value) {
        //            echoA("Email не совпадают");
        //        }
        //    }
        //}

        /**
         * Провверка корректности введенного логина
         */
        function validateLogin() {
            var expr = /[^a-z_0-9]/i;
            /**
             * Логин не может начинаться с цыфры.
             * Логин должен состоять только из цыфровых, латинских символов и знака подчеркивания.
             */
            if (registrationForm['login'].value.substring(0, 1).match(/\d/)) {
                validateField(false, 'login', localization['validLoginNDig']);
            } else if (registrationForm['login'].value.match(expr)) {
                validateField(false, 'login', localization['validLoginABC']);
            } else {
                validateField(true, 'login');
            }
        }

        /**
         * Исправляет некоторые ошибки при выводе текста
         */
        function string_normalize(form, e) {
            for (var i = 0; i < e.length; i++) {
                switch (form) {
                    case 'registrationForm':
                        if (registrationForm[e[i]].value === '/') {
                            registrationForm[e[i]].value = '';
                        }
                        break;
                    case 'authorizationForm':
                        if (this.authorizationForm['login'].value == '/') {
                            this.authorizationForm['login'].value = '';
                        }
                        break;
                }
            }
        }

        /**
         * Оповещает о некорректно введенных данных.
         * Окрашивая в красный цвет бордер соответствующего элемента,
         * и выводя соответствующую надпись об ошибке.
         */
        function validateField(sw, el, msg) {
            var fieldErrorContent = document.getElementById(el + '_error_content');

            switch (sw) {
                case true:
                    this.registrationForm[el].style.border = "1px solid #808080";
                    fieldErrorContent.style.display = "none";
                    fieldErrorContent.innerHTML = '';
                    break;
                case false:
                    if (!isUndef(this.registrationForm[el])) {
                        this.registrationForm[el].style.border = "1px solid red";
                    } else if (!isUndef(this.authorizationForm[el])) {
                        this.authorizationForm[el].style.border = "1px solid red";
                    }
                    fieldErrorContent.style.display = "block";
                    fieldErrorContent.innerHTML = msg;
                    break;
            }
        }

        // Валидация вводимых в поле login значений
        function validateAuth() {
            var loginErrorContent = document.getElementById('login_error_content'),
                passwordErrorContent = document.getElementById('password_error_content');
            var expr = /[^a-z0-9_]/i;
            loginErrorContent.innerHTML = "";
            loginErrorContent.style.display = "none";
            authorizationForm['login'].style.border = "1px solid #808080";
            passwordErrorContent.innerHTML = "";
            passwordErrorContent.style.display = "none";
            authorizationForm['password'].style.border = "1px solid #808080";
            if (authorizationForm['login'].value === '') {
                //loginErrorContent.innerHTML = "Поле ввода логина не может быть пустым";
                //loginErrorContent.style.display = "block";
                //authorizationForm['login'].style.border = "1px solid red";
            } else {
                if (authorizationForm['login'].value.match(expr)) {
                    loginErrorContent.innerHTML = localization['validLoginNABC'];
                    loginErrorContent.style.display = "block";
                    authorizationForm['login'].style.border = "1px solid red";
                }
                if (authorizationForm['login'].value.substring(0, 1).match(/\d/)) {
                    loginErrorContent.innerHTML = localization[validLoginNABC];
                    loginErrorContent.style.display = "block";
                    authorizationForm['login'].style.border = "1px solid red";
                }
            }

            if (authorizationForm['password'].value.length === 0) {
                //passwordErrorContent.innerHTML = "Авторизация без пароля невозможна"
                //passwordErrorContent.style.display = "block";
                //authorizationForm['password'].style.border = "1px solid red";
            } else if (authorizationForm['password'].value.length < 6 && authorizationForm['password'].value.length >= 1) {
                passwordErrorContent.innerHTML = localization['validPasswordShort'];
                passwordErrorContent.style.display = "block";
                authorizationForm['password'].style.border = "1px solid red";
            }
        }

        /**
         * Проверяет на корректность фамилию
         */
        function validationLastname() {
            var expr = /[^a-zа-я]/i;
            if (registrationForm['lastname'].value.match(expr)) {
                validateField(false, 'lastname', localization['validLastnameABC']);
            } else {
                validateField(true, 'lastname');
            }
        }

        /**
         * Проверяет на корректность имя
         */
        function validationFirstname() {
            var expr = /[^a-zа-я]/i;
            if (registrationForm['firstname'].value.match(expr)) {
                validateField(false, 'firstname', localization['validFirstnameABC']);
            } else {
                validateField(true, 'firstname');
            }
        }

        /**
         * Проверяет на корректность отчество
         */
        function validationPatroname() {
            var expr = /[^a-zа-я]/i;
            if (registrationForm['patroname'].value.match(expr)) {
                validateField(false, 'patroname', localization['validPatronameABC']);
            } else {
                validateField(true, 'patroname');
            }
        }

        /**
         * Проверяет на корректность Email
         */
        function validateEmail() {
            validateField(true, 'emailConfirm');
            validateField(true, 'additionalEmailConfirm');
            validateField(true, 'email');
            validateField(true, 'additionalEmail');
            var expr = /[a-z0-9]+@[a-z0-9]+\.[a-z]{2,3}/i;
            if (registrationForm['email'].value !== '') {
                if (!registrationForm['email'].value.match(expr)) {
                    validateField(false, 'email', localization['validInvalEmailFormat']);
                }
                if (registrationForm['email'].value !== registrationForm['emailConfirm'].value &&
                    registrationForm['emailConfirm'].value !== '') {
                    validateField(false, 'emailConfirm', localization['validEmailNEqual']);
                }
            }
            if (registrationForm['additionalEmail'].value !== '') {
                if (!registrationForm['additionalEmail'].value.match(expr)) {
                    validateField(false, 'additionalEmail', localization['validInvalEmailFormat']);
                }
                if (registrationForm['additionalEmail'].value !== registrationForm['additionalEmailConfirm'].value &&
                    registrationForm['additionalEmailConfirm'].value !== '') {
                    validateField(false, 'additionalEmailConfirm', localization['validEmailNEqual']);
                }
                if (registrationForm['email'].value === registrationForm['additionalEmail'].value) {
                    validateField(false, 'additionalEmailConfirm', localization['validEmailMainAndAddEqual']);
                    validateField(false, 'emailConfirm', localization['validEmailMainAndAddEqual']);
                }
            }
        }

        //function validateEmailConfirm() {
        //    //echoA('kek');
        //    if (registrationForm['email'].value !== registrationForm['emailConfirm'].value) {
        //        validateField(false, 'emailConfirm', 'Email не соответствуют друг другу');
        //    } else {
        //        validateField(true, 'emailConfirm');
        //    }
        //}
        //
        //function validateAdditionalEmail() {
        //
        //}
        //
        //function validateAdditionalEmailConfirm() {
        //    if (registrationForm['additionalEmail'].value !== registrationForm['additionalEmailConfirm'].value) {
        //        validateField(false, 'additionalEmailConfirm', 'Email не соответствуют друг другу');
        //    } else {
        //        validateField(true, 'additionalEmailConfirm');
        //    }
        //}


        /**
         * Инициализируются все обработчики событий
         */
        function initListeners() {
            if (!isUndef(this.registrationForm)) {
                document.addEventListener('load', string_normalize('registrationForm', ['lastname', 'firstname', 'patroname']));
                this.registrationForm['lastname'].addEventListener('blur', validationLastname);
                this.registrationForm['firstname'].addEventListener('blur', validationFirstname);
                this.registrationForm['patroname'].addEventListener('blur', validationPatroname);
                this.registrationForm['photo'].addEventListener('change', fileSelectEvent);
                this.registrationForm['birthYear'].addEventListener('change', validateBirthday);
                this.registrationForm['birthMonth'].addEventListener('change', validateBirthday);
                this.registrationForm['birthDay'].addEventListener('change', validateBirthday);
                this.registrationForm['login'].addEventListener('blur', validateLogin);
                this.registrationForm['password'].addEventListener('blur', validatePassword);
                this.registrationForm['passwordConfirm'].addEventListener('blur', validatePassword);
                this.registrationForm['phone'].addEventListener('blur', validatePhone);

                this.registrationForm['email'].addEventListener('blur', validateEmail);
                this.registrationForm['additionalEmail'].addEventListener('blur', validateEmail);
                this.registrationForm['emailConfirm'].addEventListener('blur', validateEmail);
                this.registrationForm['additionalEmailConfirm'].addEventListener('blur', validateEmail);

                countrySelect = document.forms['registrationForm'].elements['country'];
                citySelect = document.forms['registrationForm'].elements['city'];
                countrySelect.addEventListener('change', cityActualization);
            }
            if (!isUndef(this.authorizationForm)) {
                document.addEventListener('load', string_normalize('authorizationForm', ['login']));
                this.authorizationForm['login'].addEventListener('blur', validateAuth);
                this.authorizationForm['password'].addEventListener('blur', validateAuth);
            }
        }

        /**
         * В зависимости от того, какая страна выбрана, выдаем соответствующие для нее города,
         * так, что просто достаточно добавить информацио о самом городе
         */
        cities = {
            msc: {title: localization['cityMsk'], country: "ru", name: "msc"},
            wsh: {title: localization['cityWsh'], country: "us", name: "wsh"},
            prs: {title: localization['cityPrs'], country: "fr", name: "prs"},
            tky: {title: localization['cityTky'], country: "jp", name: "tky"},
            nyk: {title: localization['cityNyk'], country: "us", name: "nyk"},
            mrs: {title: localization['cityMrs'], country: "fr", name: "mrs"},
            spb: {title: localization['citySpb'], country: "ru", name: "spb"},
            brl: {title: localization['cityBrl'], country: "de", name: "brl"},
            ram: {title: localization['cityRam'], country: "de", name: "ram"},
            kyo: {title: localization['cityKyo'], country: "jp", name: "kyo"}
        };


        cityActualization = function () {
            citySelect.innerHTML = '';
            for (var city in cities) {
                if (cities[city].country == countrySelect.value.toString()) {
                    cityName = cities[city].title;
                    citySelect.innerHTML += "<option value='" + cities[city].name + "'> " + cityName + " </option> ";
                    echoL(cities[city]); //@debug
                }
            }
        }

        initListeners();

        //validateField('lastname'); //@debug

    }
};

App.script();