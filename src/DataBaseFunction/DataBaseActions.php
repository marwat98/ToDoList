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

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $press = $_POST['press'];
        $note = $_POST['note'];
        $categories = $_POST['categories'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $checkEmail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $password = $_POST['password'];
        $checkPassword = $_POST['checkPassword'];
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
                        echo "Error: " . $e->getMessage();
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
                    echo "Error: " . $e->getMessage();
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
                    echo "Error: " . $e->getMessage();
                }
            break;
            case "register":
                try{
                    if (empty($username) || empty($email) || empty($password)) {
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
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $registerUser = new RegisterUser($db, $message);
                    $registerUser->createAcount($username, $email, $hashedPassword, $template);
                    
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            break;
            case "login":
                try{
                    if (empty($username) ||  empty($password)) {
                        throw new Exception("Nie wprowadzono wszystkich danych.");
                    }
                    $login = new LoginToAcount($db,$message);
                    if($login->loginOnAccount($username,$password,$template)){
                        $_SESSION['auth'] == true;
                    }
                } catch(Exception $e){
                    echo "Error: " . $e->getMessage();
                }
        }
    }  

?> 