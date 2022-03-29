<?php

use TaskForce\Main\ActionCancel;
use TaskForce\Main\ActionRespond;
use TaskForce\Main\TaskMain;

error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php
         require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

         function debugResult($result) {
             echo '<pre>';
             echo print_r($result);
             echo '</pre>';
         }

         function myAssertHandler($file, $line, $code)
            {
                echo "<hr>Неудачная проверка утверждения:
                    Файл '$file'<br />
                    Строка '$line'<br />
                    Код '$code'<br /><hr />";
            }

         $task = new TaskMain( 1, 21, 'new');

         if ($task->getStatusesMap()) {
              debugResult($task->getStatusesMap());
         }
         if ($task->getActionsMap()) {
              debugResult($task->getActionsMap());
         }

         $resultAction1 = $task->getActionsListByStatus( 'new', 1 )::getCode();
         $resultAction21 = $task->getActionsListByStatus( 'new', 21 )::getCode();
         $resultStatus = $task->getNextStatusByAction('cancel');

         assert_options(ASSERT_CALLBACK, 'myAssertHandler');

         if (assert($resultStatus == TaskMain::STATUS_CANCELED, 'canceled')) {
             echo 'метод получения следующего статуса проверен!';
             echo '<br>';
         }

         if (assert($resultAction1 == ActionRespond::getCode(), 'respond')
         ) {
             echo 'метод получения доступных действий для статуса и пользователя ID=1 проверен!';
             echo '<br>';
         }

        if (assert($resultAction21 == ActionCancel::getCode(), 'cancel')
        ) {
            echo 'метод получения доступных действий для статуса и пользователя ID=21 проверен!';
            echo '<br>';
        }

        ?>
    </body>
</html>
