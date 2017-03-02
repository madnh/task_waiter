<?php
/*
|--------------------------------------------------------------------------
| Example
|--------------------------------------------------------------------------
|
| Open up two command prompts and run the script twice
|
*/


require 'src\TaskWaiter.php';

use MaDnh\TaskWaiter\TaskWaiter as Task;

echo "Start example\n";
$task = 'example_task';

//Task::$savePath = __DIR__;

echo Task::isWorking($task) ? "Task is running" : 'Task is free';

print "\n";

if (Task::start($task)) {
    echo "Task is in processing!\n";

    sleep(5);
    Task::complete($task);

    echo "Task complete!\n";
    echo "Do other process!\n";

    sleep(5);
} else {
    echo "Start failed";
}

echo "Bye!";
