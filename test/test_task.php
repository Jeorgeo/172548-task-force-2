<?php

use TaskForce\main\TaskMain;

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

         $resultAction = $task->getActionsListByStatus( 'new' );
         $resultStatus = $task->getNextStatusByAction('cancel');

         assert_options(ASSERT_CALLBACK, 'myAssertHandler');

         if (assert($resultStatus == TaskMain::STATUS_CANCELED, 'canceled')) {
             echo 'метод получения следующего статуса проверен!';
             echo '<br>';
         }

         if ((assert($resultAction[1] == TaskMain::ACTION_CANCEL, 'cancel'))&&(assert($resultAction[21] == TaskMain::ACTION_RESPOND, 'respond'))) {
             echo 'метод получения доступных действий для статуса проверен!';
             echo '<br>';
         }

        ?>
    </body>
</html>
