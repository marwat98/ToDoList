<?php 
    require_once('config.php');
    use ShowNotes\ShowContent;

    try {
        $sqlSelect = "SELECT note , count from addToDataBase";
        $template = "message.html.twig";

        $showContent = new ShowContent($twig);
        $data = $showContent->dataBaseContent($sqlSelect,$template);

    } catch (Exception $e) {
        $twig->display('message.html.twig',['message' => $e->getMessage()]);
        exit();
    }

    $twig->display('header.html.twig');

    echo $twig->render('addToDo.html.twig', ['data' => $data]);

    $twig->display('scripts.html.twig');

    $twig->display('footer.html.twig');
?>
