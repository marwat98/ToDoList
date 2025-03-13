 <?php
    require_once ('C:\xampp\htdocs\ToDoList\config.php');
    use DataBaseFunction\AddEditToDataBase;
    use DataBaseFunction\DeleteFromDataBase;
    use MessageTwigFunction\MessageHandler;
    use DataBaseConnection\DataBase;
    use DataBaseFunction\RegisterUser;
    use DataBaseFunction\LoginToAcount;

    $db = new DataBase("localhost","root","","toDoList");
    $message = new MessageHandler($twig);
    $template = "message.html.twig";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $press = $_POST['press'];
        $note = $_POST['note'] ?? null;
        $categories = $_POST['categories'] ?? null;
        $loginUser = $_POST['loginUser'];
        $email = $_POST['email'] ?? null;
        $checkEmail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $password = $_POST['password'];
        $checkPassword = $_POST['checkPassword'] ?? null;
        $pieces = isset($_POST['pieces']) ? (int)$_POST['pieces'] : null;
        $id2 = isset($_POST['id2']) ? (int)$_POST['id2'] : null;

        switch($press){
            // Action which addition notes 
            case "addNote":
                try{
                    if(empty($note)){
                        throw new Exception("Użytkownik nie wpisał notatki");
                    } else {
                        $sqlInsertData = "INSERT INTO addtodatabase (note,category,pieces) VALUES (?,?,?)";
                        $addToDataBase = new AddEditToDataBase($db,$message);
                        $addToDataBase->addEditNote(null,$note,$categories,$pieces,$template,$sqlInsertData);
                    }

                } catch (Exception $e) {
                    $this->message->showMessage($template, "Error: " . $e->getMessage(), false);
                }
            break;
            // Action which edit notes 
            case "editNote":
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
            break;
            // Action which deleting notes
            case "deleteNote":
                try{
                    $id = (int)$_POST['id'];
                    $sqlDelete = "DELETE FROM addtodatabase WHERE id = ?";
                    $deleteFromDataBase = new DeleteFromDataBase($db,$message);
                    $deleteFromDataBase->deleteNote($id,$template,$sqlDelete);
                } catch (Exception $e) {
                    $this->message->showMessage($template, "Error: " . $e->getMessage(), false);
                }
            break;
            //Action register account
            case "register":
                try{
                    if (empty($loginUser) || empty($email) || empty($password)) {
                        throw new Exception("Nie wprowadzono wszystkich danych.");
                    }
                    if (strlen($username) > 10) {
                        throw new Exception("Nazwa użytkownika jest zbyt długa. Maksymalna długość to 10 znaków.");
                    }
                    if (!preg_match($checkEmail, $email)) {
                        throw new Exception("Podana nazwa nie jest mailem.");
                    }
                    if ($password !== $checkPassword) {
                        throw new Exception("Hasła nie są identyczne.");
                    }
                    $registerUser = new RegisterUser($db, $message);
                    $registerUser->createAcount($loginUser, $email, $password, $template);
                    
                } catch (Exception $e) {
                    $this->message->showMessage($template, "Error: " . $e->getMessage(), false);
                }
            break;
            //Action login account
            case "login":
                try {
                    if (empty($loginUser) || empty($password)) {
                        throw new Exception("Nie wprowadzono wszystkich danych.");
                    }
                    $loginAccount = new LoginToAcount($db, $message);
                    if($loginAccount->login($loginUser, $password, $template)){
                        session_start();
                        $_SESSION['auth'] = true;
                        header("Location: /ToDoList/add");
                        exit();
                    };  

                } catch (Exception $e) {
                    $this->message->showMessage($template, "Error: " . $e->getMessage(), false);
                }
            break;
            
    }  
}

?> 