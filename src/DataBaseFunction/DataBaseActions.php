 <?php
    require_once(__DIR__ . '/../../vendor/autoload.php');
    require_once(__DIR__ . '/../../config.php');
    use DataBaseFunction\AddToDataBase;
    use MessageTwigFunction\MessageHandler;
    use DataBaseConnection\DataBase;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_POST["note"]) || empty(trim($_POST["note"]))){
            throw new Exception("Don't POST variable to data base");
        } else {
            $note = $_POST['note'];
            $template = "message.html.twig";
            $sqlInsertData = "INSERT INTO addToDataBase (note) VALUES (?)";
            $db = new DataBase("localhost","root","","toDoList");
            $message = new MessageHandler($twig);
            
            $addToDataBase = new AddToDataBase($db,$message);
            $addToDataBase->addNote($note,$template,$sqlInsertData);
        }
    }
?> 