<?php

namespace TaskForce\Main;

/**
 * Класс для работы с сущностью «Задание»
 *
 * Проект «TaskForce»
 *
 * Автор Yury Shakhousky
 */
class TaskMain
{

    /** @var string STATUS_NEW Задание опубликовано, исполнитель ещё не найден */
    /** @var string STATUS_CANCELED Заказчик отменил задание */
    /** @var string STATUS_APROVED Заказчик выбрал исполнителя для задания */
    /** @var string STATUS_DONE Заказчик отметил задание как выполненное */
    /** @var string STATUS_FAIL Исполнитель отказался от выполнения задания */

    /** @var string ACTION_CANCEL Заказчик Отменить */
    /** @var string ACTION_COMPLETE Заказчик Выполнено */
    /** @var string ACTION_RESPOND Исполнитель Откликнуться */
    /** @var string ACTION_REFUSE Исполнитель Отказаться */

    /** @var array TASK_STATUSES возможные статусы задания */
    /** @var array TASK_ACTIONS возможные действия по заданию */

    /** @var string currentTaskStatus текущий статус задания */
    /** @var int customerID ID заказчика */
    /** @var int employeeID ID исполнителя */

    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_APROVED = 'aproved';
    const STATUS_DONE = 'done';
    const STATUS_FAIL = 'fail';

//    const ACTION_CANCEL = 'cancel';
//    const ACTION_COMPLETE = 'complete';
//    const ACTION_RESPOND = 'respond';
//    const ACTION_REFUSE = 'refuse';

    const TASK_STATUSES = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELED => 'Отменено',
        self::STATUS_APROVED => 'В работе',
        self::STATUS_DONE => 'Выполнено',
        self::STATUS_FAIL => 'Провалено'
    ];

    private string $currentTaskStatus;
    private int $customerID;
    private int $employeeID;

    function __construct($customerID, $employeeID, $currentTaskStatus)
    {
        $this->customerID = $customerID;
        $this->employeeID = $employeeID;
        $this->currentTaskStatus = $currentTaskStatus;
    }

    /**
     * Получение «карты» статусов
     *
     * @return array
     */

    public function getStatusesMap():array
    {
        return self::TASK_STATUSES;
    }

    /**
     * Получение «карты» действий
     *
     * @return array
     */

    public function getActionsMap():array
    {
        return [
            ActionCancel::getCode() => ActionCancel::getName(),
            ActionRespond::getCode() => ActionRespond::getName(),
            ActionComplete::getCode() => ActionComplete::getName(),
            ActionRefuse::getCode() => ActionRefuse::getName()
        ];
    }

    /**
     * Получение следующего статуса по "Заданию"
     *
     * @param string текущее действие в "Задании"
     *
     * @return string статус сущности
     */

    public function getNextStatusByAction( $currentTaskAction ):string
    {
        return match ($currentTaskAction) {
            ActionRespond::getCode() => self::STATUS_APROVED,
            ActionCancel::getCode() => self::STATUS_CANCELED,
            ActionRefuse::getCode() => self::STATUS_FAIL,
            default => self::STATUS_DONE,
        };
    }

    /**
     * Получение доступных действий для статуса по "Заданию"
     * @param string текущий статус в "Заданию"
     * @param integer текущий ID пользователя
     *
     * @return object/null список доступных действий
     */

    public function getActionsListByStatus( $currentTaskStatus, $userID ):object
    {
        $usersList = [
            $this->employeeID,
            $this->customerID,
            $userID
        ];

        switch ($currentTaskStatus) {
            case (self::STATUS_NEW):
                if (ActionCancel::checkAccess( ...$usersList ))
                {
                    $action = new ActionCancel();
                };
                if (ActionRespond::checkAccess( ...$usersList ))
                {
                    $action = new ActionRespond();
                };
                break;
            case (self::STATUS_APROVED):
                if (ActionComplete::checkAccess( ...$usersList ))
                {
                    $action = new ActionComplete();
                };
                if (ActionRefuse::checkAccess( ...$usersList ))
                {
                    $action = new ActionRefuse();
                };
                break;
            default:
                $action = null;
                break;
        }
        return $action;
    }

}

;
?>
