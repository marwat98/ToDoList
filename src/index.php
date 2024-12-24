<?php 
require_once('config.php');
require_once('src/ShowNotes/ShowContent.php');


$showContent = new ShowContent();
$data = $showContent->dataBaseContent();

$twig->display('header.html.twig');

$twig->display('addToDo.html.twig');

echo $twig->render('showToDoList.html.twig', ['data' => $data]);

$twig->display('scripts.html.twig');

$twig->display('footer.html.twig');
?>
