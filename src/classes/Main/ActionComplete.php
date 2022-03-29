<?php

namespace TaskForce\Main;

/**
 * Класс-действие Выполнено
 *
 * Проект «TaskForce»
 *
 * Автор Yury Shakhousky
 */

class ActionComplete extends TaskAction
{
    const ACTION_NAME = 'Выполнено';
    const ACTION_CODE = 'done';

    /**
     * Возвращает название действия
     *
     * @return string
     */

    public static function getName():string
    {
        return self::ACTION_NAME;
    }

    /**
     * Возвращает внутреннее имя действия
     *
     * @return string
     */

    public static function getCode():string
    {
        return self::ACTION_CODE;
    }

    /**
     * Проверяет группу пользователя
     * Возвращает true или false
     * (в зависимости от доступности выполнения этого действия)
     *
     * @param $customerID
     * @param $employeeID
     * @param $userID
     * @return bool
     */

    public static function checkAccess($customerID, $employeeID, $userID ):bool
    {
        return $customerID === $userID;
    }
}
