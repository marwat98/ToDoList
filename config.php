<?php 
require_once('vendor/autoload.php');

$loader = new Twig\Loader\FilesystemLoader( "/opt/lampp/htdocs/ToDoList/src/templatess");

$twig = new Twig\Environment($loader);


?>