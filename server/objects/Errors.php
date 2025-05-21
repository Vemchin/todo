<?php
enum Errors: string
{
    case Empty = 'Task Cannot be empty!';
    case Duplicated = 'Task already exists!';
    case NotFound = 'Task not found!';
}

function setError(Errors $error)
{
    setcookie("error", $error->value, time()
        + 5, '/');
}
