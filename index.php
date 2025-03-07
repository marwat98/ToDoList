<?php 
    require_once('config.php');
    use ShowNotes\ShowContent;
    use Steampixel\Route;

    Route::add('/',function(){
        global $twig;
        $twig->display('home.html.twig');
    });
    Route::add('/login',function(){
        global $twig;
        $twig->display('login.html.twig');
    });
    Route::add('/register',function(){
        global $twig;
        $twig->display('register.html.twig');
    });
    Route::add('/add',function(){
       global $twig;
        try {
            $id = isset($_GET['modal_id']) ? $_GET['modal_id'] : null;

            $sqlSelect = "SELECT * FROM addToDataBase";
            $showContent = new ShowContent($twig);
            $data = $showContent->dataBaseContent($sqlSelect, "message.html.twig");

            echo $twig->render('addNote.html.twig', ['data' => $data]);
            echo $twig->render('modal.html.twig', ['data' => $id]);

        } catch (Exception $e) {
            $twig->display('message.html.twig',['message' => $e->getMessage()]);
            exit();
        }

    });
    
    Route::run('/ToDoList');

?>

