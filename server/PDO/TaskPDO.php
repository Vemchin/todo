<?php
require_once(__DIR__ . '/../objects/Task.php');

class TaskPDO
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Task $task): void
    {
        $sql = "INSERT INTO tasks (description, done) VALUES (:description, :done)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'description' => $task->description,
            'done' => $task->done,
        ]);
    }

    public function getAll(): array
    {
        $sql = "SELECT id, description, done FROM tasks";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll();
    }

    public function getById(int $id): ?Task
    {
        $sql = "SELECT id, description, done FROM tasks WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id' => $id]);
        $task = $stmt->fetch();


        return $task ? new Task($task['description'], $task['done']) : null;
    }

    public function update(Task $task): void
    {
        $sql = "UPDATE tasks SET description = :description, done = :done WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'description' => $task->description,
            'done' => $task->done,
            'id' => $task->id
        ]);
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id => $id']);
    }

    public function deleteAll(): void
    {
        $sql = "TRUNCATE TABLE tasks";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();
    }
}
