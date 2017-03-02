<?php

namespace MaDnh\TaskWaiter;

class TaskWaiter
{
    protected static $tasks = [];

    /**
     * Place to save task files
     * @var string
     */
    public static $savePath = __DIR__ . DIRECTORY_SEPARATOR . 'tasks';

    protected static function getTaskFile($taskName)
    {
        return rtrim(self::$savePath, '\\/') . DIRECTORY_SEPARATOR . $taskName . '.txt';
    }

    /**
     * Start a task
     * @param string $taskName
     * @return bool
     */
    public static function start($taskName)
    {
        if (!array_key_exists($taskName, self::$tasks)) {
            $taskFile = self::getTaskFile($taskName);

            try {
                $fp = @fopen($taskFile, "w");

                if (false === $fp) {
                    return false;
                }
            } catch (\Exception $e) {
                return false;
            }

            self::$tasks[$taskName] = $fp;
        }

        return flock(self::$tasks[$taskName], LOCK_EX);
    }

    public static function isWorking($taskName)
    {
        if (array_key_exists($taskName, self::$tasks)) {
            return true;
        }

        try {
            $taskFile = self::getTaskFile($taskName);

            if (!file_exists($taskFile)) {
                return false;
            }
            $wrote = @file_put_contents($taskFile, '_');
            if (false !== $wrote) {
                return false;
            }
        } catch (\Exception $e) {
            //
        }

        return true;
    }

    public static function complete($taskName)
    {
        if (!array_key_exists($taskName, self::$tasks)) {
            return;
        }

        @flock(self::$tasks[$taskName], LOCK_UN);
        @fclose(self::$tasks[$taskName]);
        unset(self::$tasks[$taskName]);
    }
}