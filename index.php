<?php
require_once('./server/services/TaskService.php');

$service = new TaskService();

$tasks = $service->getALL();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To-Do List</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="icon" type="image/png" sizes="32x32" href="./img/icon.png">
</head>

<body>

  <div class="container">
    <div class="todo-app">
      <!-- Error -->
      <?php if (isset($_COOKIE['error'])): ?>
        <div class="error-card"></div>
        <div class="error-icon">!</div>
        <div class="error-message">
          <strong>Error:<strong> <?= $_COOKIE['error']; ?>
        </div>
    </div>
    <?php unset($_COOKIE['error']); ?>
  <?php endif; ?>


  <!-- App -->
  <h2>ToDo List <img src="img/icon.png"></h2>
  <form method="post" class="row">
    <input type="text" name="task" ; id="input-box" placeholder="Add your text">

    <button type="submit" formaction="./server/operations/add.php">Add</button>
  </form>

  <!-- Task container -->
  <ul id="list-container">
    <?php foreach ($tasks as $task): ?>
      <form method="post">
        <li>
          <p> <?= $task['description'] ?> </p>
        </li>

        <button type="submit" formaction="./server/operations/Delete.php">
          <span>&#x00D7</span>
        </button>
      </form>
    <?php endforeach; ?>
    <!-- <li class="checked">Task 1</li>
        <li>Task 2</li>
        <li>Task 3</li> -->
  </ul>
  </div>
  </div>

  <script src="script.js"></script>
</body>

</html>