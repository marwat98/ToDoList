<?php 
require_once('config.php');

$twig->display('header.html.twig');
$twig->display('mainPage.html.twig');
$twig->display('scripts.html.twig');
$twig->display('footer.html.twig');

?>