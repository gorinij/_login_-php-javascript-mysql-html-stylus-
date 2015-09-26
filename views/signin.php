<?php
    /**
     * Created by PhpStorm.
     * User: hardriser
     * Date: 31.08.2015
     * Time: 19:49
     */
    //    namespace login\view;
?>
<div id="signin">
    <div class="wrapper form localization">
        <form method="post" action="">
            <select name="localization" id="">
                <option value="0">Русский</option>
                <option value="1">English</option>
            </select>
            <input value="<?= $locale[chooseLanguage] ?>" type="submit"/>
        </form>
    </div>
    <div class="wrapper inner signin">
        <form action="../index.php" id="authorizationForm" method="post">
            <input name="r" type="hidden" value="auth"/>
            <input name="form" type="hidden" value="signin"/>
            <h2><?= $locale[signin] ?></h2>
            <ul class="nonStyle">
                <li>
                    <input
                        type="text"
                        name="regData[login]"
                        id="login"
                        placeholder=<?= $locale[login] ?>
                        value=<?= $login_ ?>
                        />
                <li>
                    <div id="login_error_content" class="validation_error_content"><?= $locale[validationError] ?></div>
                </li>
                <li><input id="password" type="password" name="regData[password]" placeholder=<?= $locale[password] ?>></li>
                <li>
                    <div id="password_error_content" class="validation_error_content"><?= $locale[validationError] ?></div>
                </li>
                <li>
                    <label>
                        <input type="checkbox" disabled/>
                        <?= $locale[rememberMe] ?>
                    </label>
                </li>
                <li><input type="submit" value="OK"/></li>
                <li><a href="?r=signup" style="float: right;"><?= $locale[toRegistration] ?></a></li>
            </ul>
        </form>
    </div>
</div>