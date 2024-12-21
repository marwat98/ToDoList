<?php 
require_once('config.php');

$twig->display('header.html.twig');
$twig->display('addToDo.html.twig');
$twig->display('showToDoList.html.twig');
$twig->display('scripts.html.twig');
$twig->display('footer.html.twig');

?>