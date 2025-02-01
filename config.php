<?php 
require_once('vendor\autoload.php');

$loader = new Twig\Loader\FilesystemLoader('C:\xampp\htdocs\ToDoList\src\Templatess');

$twig = new Twig\Environment($loader);


?>