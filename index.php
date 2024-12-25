<?php 
require_once('src/config.php');
use ShowNotes\ShowContent;

$showContent = new ShowContent();
$data = $showContent->dataBaseContent();

$twig->display('header.html.twig');

$twig->display('addToDo.html.twig');

echo $twig->render('showToDoList.html.twig', ['data' => $data]);

$twig->display('scripts.html.twig');

$twig->display('footer.html.twig');
?>
