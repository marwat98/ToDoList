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
    $loginUser = $_POST['loginUser'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $checkPassword = $_POST['checkPassword'] ?? null;
    $pieces = isset($_POST['pieces']) ? (int)$_POST['pieces'] : null;
    $id2 = isset($_POST['id2']) ? (int)$_POST['id2'] : null;

    Route::add('/home',function() use ($twig){
        $twig->display('home.html.twig');
    });
    Route::add('/login',function() use ($twig){
        $twig->display('login.html.twig');
    });
    Route::add('/login',function() use ($loginUser,$password,$db,$message,$template){
        try{
            if(empty($loginUser) || empty($password)){
                $this->message->showMessage($template, "Nie wprowadzono wszystkich danych");
                exit();
            } else {
                $loginAccount = new LoginToAcount($db, $message);
                if($loginAccount->login($loginUser, $password, $template)){
                    session_start();
                    $_SESSION['auth'] = true;
                    header("Location: /ToDoList/add");
                }   
            }
        }catch (Exception $e) {
            $this->message->showMessage($template, "Error: " . $e->getMessage());
        }
    });
    Route::add('/register',function() use ($twig){
        $twig->display('register.html.twig');
    });
    Route::add('/register',function() use ($db,$message,$template,$loginUser,$email,$password,$checkPassword){
        try{
            if (empty($loginUser) || empty($email) || empty($password)) {
                throw new Exception("Nie wprowadzono wszystkich danych.");
            }
            if (strlen($loginUser) > 10) {
                throw new Exception("Nazwa użytkownika jest zbyt długa. Maksymalna długość to 10 znaków.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Podany adres e-mail jest nieprawidłowy.");
            }
            if ($password !== $checkPassword) {
                throw new Exception("Hasła nie są identyczne.");
            }
            $registerUser = new RegisterUser($db, $message);
            if(!$registerUser->createAcount($loginUser, $email, $password, $template)){
                throw new Exception("Nie udało się utworzyć konta.");
            }
            header("Location: /ToDoList/login");

        } catch (Exception $e) {
            $this->message->showMessage($template, "Error: " . $e->getMessage());
        }
    });
    Route::add('/add',function() use ($twig,$template){
        try {
            $id = isset($_GET['modal_id']) ? $_GET['modal_id'] : null;

            $sqlSelect = "SELECT * FROM addToDataBase";
            $showContent = new ShowContent($twig);
            $data = $showContent->dataBaseContent($sqlSelect, "message.html.twig");

            echo $twig->render('addNote.html.twig', ['data' => $data]);
            echo $twig->render('modal.html.twig', ['data' => $id]);

        } catch (Exception $e) {
            $this->message->showMessage($template, "Error: " . $e->getMessage());
        }
    });
    Route::add('/addNote',function() use ($db,$message,$note,$categories,$pieces,$template){
        try{
            if(empty($note)){
                throw new Exception("Użytkownik nie wpisał notatki");
            } else {
                $sqlInsertData = "INSERT INTO addtodatabase (note,category,pieces) VALUES (?,?,?)";
                $addToDataBase = new AddEditToDataBase($db,$message);
                $addToDataBase->addEditNote(null,$note,$categories,$pieces,$template,$sqlInsertData);
            }
        } catch (Exception $e) {
            $this->message->showMessage($template, "Error: " . $e->getMessage());
        }
    });
    Route::add('/editNote',function() use ($db,$message,$id2,$note,$categories,$pieces,$template) {
        try{
            if(empty($note)){
                throw new Exception("Użytkownik nie edytował notatki");
            } else {
                $sqlInsertData = "UPDATE addtodatabase SET note = ? , category = ? , pieces = ? WHERE id = ?";
                $editNote = new AddEditToDataBase($db,$message);
                $editNote->addEditNote($id2,$note,$categories,$pieces,$template,$sqlInsertData);
            }
        } catch (Exception $e) {
            $this->message->showMessage($template, "Error: " . $e->getMessage(), false);
        }
    });

    Route::add('/logout', function(){
        session_destroy();
        header("Location: /ToDoList/home");
        exit();
    });

    Route::run('/ToDoList');
    

?>

