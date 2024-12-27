<?php 
require_once('vendor/autoload.php');

$loader = new Twig\Loader\FilesystemLoader( "/opt/lampp/htdocs/ToDoList/src/templates");

$twig = new Twig\Environment($loader);


?>