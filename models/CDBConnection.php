<?php
/**
 * Created by PhpStorm.
 * User: hardriser
 * Date: 10.09.2015
 * Time: 22:52
 */

namespace app\model;

include_once('TSingleton.php');

use app\TSingleton;

class CDBConnection
{
    const
        HOST = 'localhost',
        USER = 'root',
        PASS = '',
        DB = 'test_login';

//  Объявляем класс синглтоном. Если ничего не испортить изнутри,
//  данный класс сможет иметь только один экземпляр объекта.
    use TSingleton;

//  Ссылка на подключение к базе данных
    private static $dbConnection;

//  Переопределяем конструктор синглтона.
    private function __construct($host = "localhost", $user = "root", $password = "", $database = "login")
    {
        if (!self::setDbConnection($host, $user, $password, $database)) {
            die('DBConnecting failure');
        }
    }

    /**
     * Возвращает объект для работы с БД.
     * @param string $host  Адрес расположения БД
     * @param string $user  Имя пользователя для подключения к БД
     * @param string $password  Пароль пользователя для подключения к БД
     * @param string $database  Имя БД
     * @return CDBConnection    Объект-синглтон для работы с БД
     */
    public static function getInstance($host = "localhost", $user = "root", $password = "", $database = "login")
    {
        if (self::$_instance === null) {
            self::$_instance = new self($host, $user, $password, $database);
        }
        return self::$_instance;
    }

    /**
     * Функция для работы с БД
     * @param $query
     * @return array|null Возвращает массив данных из БД если была оправлен запрос SELECT
     * и TRUE или FALSE, если отправлены запросы INSERT, UPDATE и т.д. в зависимости от
     * того, удалось произвести изменение или нет
     */
    public static function executeQuery($query)
    {
        CDBConnection::getInstance(self::HOST, self::USER, self::PASS, self::DB);
        $dbResult = mysqli_query(self::$dbConnection, $query);
        if (!(is_bool($dbResult))) {
            $res = mysqli_fetch_all($dbResult, MYSQLI_ASSOC);
        }
        return $res;
    }

    /**
     * Внутренний класс для установки соединения с БД
     * @param string $host  Адрес расположения БД
     * @param string $user  Имя пользователя для подключения к БД
     * @param string $password  Пароль пользователя для подключения к БД
     * @param string $database  Имя БД
     * @return boolean  Возвращает FALSE, если произошла ошибка подключения к БД и TRUE если подключение удалось
     */
    private static function setDbConnection($host = "localhost", $user = "root", $password = "", $database = "login")
    {
        self::$dbConnection = mysqli_connect($host, $user, $password, $database);
        if (mysqli_errno(self::$dbConnection) == 0) {
            return true;
        }
        return false;
    }

    /**
     * Закрываем соединение с базой данных после уничтожения объекта.
     */
    function __destruct()
    {
        mysqli_close(self::$dbConnection);
    }
}