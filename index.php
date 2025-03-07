<?php 
    require_once('config.php');
    use ShowNotes\ShowContent;
    use Steampixel\Route;


    // try {
        
    //     $id = isset($_GET['modal_id']) ? $_GET['modal_id'] : null;

    //     $sqlSelect = "SELECT * FROM addToDataBase";
    //     $showContent = new ShowContent($twig);
    //     $data = $showContent->dataBaseContent($sqlSelect, "message.html.twig");

    //     $updateQuery = "SELECT * FROM addToDataBase WHERE id = '$id'";
    //     $update = $showContent->dataBaseContent($updateQuery, "message.html.twig");

    // } catch (Exception $e) {
    //     $twig->display('message.html.twig',['message' => $e->getMessage()]);
    //     exit();
    // }

    // $twig->display('header.html.twig');

    // echo $twig->render('addNote.html.twig', ['data' => $data]);

    
    // echo $twig->render('modal.html.twig', ['data' => $id]);

    // echo $twig->display('scripts.html.twig');
    // echo $twig->display('footer.html.twig');

    Route::add('/',function(){
        echo "Strona główna";
    });
    Route::add('/login',function(){
        echo "Strona logowania";
    });
    Route::add('/register',function(){
        echo "Strona rejestracji";
    });
    Route::add('/addNote',function(){
        echo "Dodaj liste zakupów";
    });
    Route::run('/ToDoList');

?>

