<?php
require_once(__DIR__ . '/../db/Connection.php');
require_once(__DIR__ . '/../PDO/TaskPDO.php');
require_once(__DIR__ . '/../objects/Task.php');
require_once(__DIR__ . '/../objects/Errors.php');
require_once(__DIR__ . '/../utils/goback.php');

class TaskService
{
    private $pdo;
    private $taskPDO;

    public function __construct()
    {
        $this->pdo = DatabaseConnection::connect();
        $this->taskPDO = new TaskPDO($this->pdo);
    }

    public function createTask(string $description): void
    {
        if (empty($description)) {
            setError(Errors::Empty);
            goBack();
        }

        $task = new Task($description, 0);
        $tasks = $this->taskPDO->getALL();

        if ($this->isDuplicated($tasks, $task)) {
            setError(Errors::Duplicated);
            goBack();
        }

        $this->taskPDO->create($task);
    }

    private function isDuplicated(array $tasks, Task $task): bool
    {
        $tasks = array_map(fn($t) => $t['description'], $tasks);

        //
        $tasks[] = $task->description;

        return count($tasks) !== count(array_unique($tasks, SORT_REGULAR));
    }
}
