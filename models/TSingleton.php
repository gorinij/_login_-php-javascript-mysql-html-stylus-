<?php
/**
 * Created by PhpStorm.
 * User: hardriser
 * Date: 11.09.2015
 * Time: 22:53
 */

namespace app;

/**
 * Трейт TSingleton реализует шаблон Синглтон.
 * Он позволяет реализовать только единственный экземпляр соответствующего класса.
 * Подключение этого трейта к классу автоматические делает его синглтоном.
 * Для соответствующих классов потребуется переопределить функции getInstance() и __construct()
 * @package app
 */
Trait TSingleton {
    protected static $_instance;

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
}