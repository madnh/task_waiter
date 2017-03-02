# Task Waiter

This class help to detect tasks in multiple simultaneous processes were completed or not.

## Install

**Composer**

```
composer require madnh/task_waiter
```

## Properties

- **static::$savePath**: place to save task files

## Methods

- **static::start(`$taskName`)**: start a task, other comming php process will hold until this task is complete or current process finished.
- **static::isWorking(`$taskName`)**: check if a task is running in any of process.
- **static::complete(`$taskName`)**: set status of a task is complete. Other processes can continue their business.

# Example

Run below example in multiple command prompts

```php
use MaDnh\TaskWaiter\TaskWaiter as Task;

echo "Start example\n";
$task = 'example_task';

//Task::$savePath = __DIR__;

echo Task::isWorking($task) ? "Task is running in other process" : 'Task is free';

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
```

[Example result image](http://i.imgur.com/xPN5QbO.gifv)

![Example result](http://i.imgur.com/xPN5QbO.gif)