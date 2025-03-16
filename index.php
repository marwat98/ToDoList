<?php 
    require_once('config.php');
    use ShowNotes\ShowContent;
    use Steampixel\Route;
    use DataBaseFunction\AddEditToDataBase;
    use DataBaseFunction\DeleteFromDataBase;
    use MessageTwigFunction\MessageHandler;
    use DataBaseConnection\DataBase;
    use DataBaseFunction\RegisterUser;
    use DataBaseFunction\LoginToAcount;

    $db = new DataBase("localhost","root","","toDoList");
    $message = new MessageHandler($twig);
    $template = "message.html.twig";

    $note = $_POST['note'] ?? null;
    $categories = $_POST['categories'] ?? null;
    $loginUser = $_POST['loginUser'];
    $email = $_POST['email'] ?? null;
    $checkEmail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $password = $_POST['password'];
    $checkPassword = $_POST['checkPassword'] ?? null;
    $pieces = isset($_POST['pieces']) ? (int)$_POST['pieces'] : null;
    $id2 = isset($_POST['id2']) ? (int)$_POST['id2'] : null;

    Route::add('/home',function() use ($twig){
        $twig->display('home.html.twig');
    });
    Route::add('/login',function() use ($twig){
        $twig->display('login.html.twig');
    });
    Route::add('/login',function() use ($twig,$loginUser,$password,$db,$message,$template){
        if(empty($loginUser) || empty($password)){
            $twig->display('message.html.twig',['message' => 'Nie wprowadzono wszystkich danych']);
            exit();
        } else {
            $loginAccount = new LoginToAcount($db, $message);
            if($loginAccount->login($loginUser, $password, $template)){
                session_start();
                $_SESSION['auth'] = true;
                header("Location: /ToDoList/add");
                exit();
            };  
        }
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
        }

    });
    Route::add('/logout', function(){
        session_destroy();
        header("Location: /ToDoList/home");
        exit();
    });

    Route::run('/ToDoList');
    

?>

