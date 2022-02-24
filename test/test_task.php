<?
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?
         require_once($_SERVER['DOCUMENT_ROOT'] . '/class/task.php');

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

         $task = new Task( 1, 21, 'new');

         if ($task->getStatusesMap()) {
              debugResult($task->getStatusesMap());
         }
         if ($task->getActionsMap()) {
              debugResult($task->getActionsMap());
         }

         $resultAction = $task->getActionsListByStatus( 'new' );
         $resultStatus = $task->getNextStatusByAction('action_cancel');

         assert_options(ASSERT_CALLBACK, 'myAssertHandler');

         if (assert($resultStatus == Task::STATUS_CANCEL, 'cancel')) {
             echo 'метод получения следующего статуса проверен!';
             echo '<br>';
         }

         if ((assert($resultAction[1] == Task::ACTION_CANCEL, 'action_cancel'))&&(assert($resultAction[21] == Task::ACTION_RESPOND, 'action_respond'))) {
             echo 'метод получения доступных действий для статуса проверен!';
             echo '<br>';
         }

        ?>
    </body>
</html>
