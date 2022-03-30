<?php

namespace TaskForce\Main;

/**
 * Абстрактный класс для описания действий в сущности "Задание"
 *
 * Проект «TaskForce»
 *
 * Автор Yury Shakhousky
 */

abstract class TaskAction
{
    /** @var int customerID ID заказчика */
    /** @var int employeeID ID исполнителя */
    /** @var int userID ID пользователя */

    protected int $customerID;
    protected int $employeeID;
    protected int $userID;

//    function __construct( $customerID, $employeeID, $userID )
//    {
//        $this->customerID = $customerID;
//        $this->employeeID = $employeeID;
//        $this->userID = $userID;
//
//    }

    function __construct()
    {
    }

    /**
     * Возвращает название действия
     *
     * @return string
     */

    abstract protected static function getName():string;

    /**
     * Возвращает внутреннее имя действия
     *
     * @return string
     */

    abstract protected static function getCode():string;

    /**
     * Проверяет группу пользователя
     * Возвращает true или false
     * (в зависимости от доступности выполнения этого действия)
     *
     * @return bool
     */

    abstract protected static function checkAccess( $customerID, $employeeID, $userID ):bool;
}
