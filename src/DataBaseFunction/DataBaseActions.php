 <?php
    require_once(__DIR__ . '/../../vendor/autoload.php');
    require_once(__DIR__ . '/../../config.php');
    use DataBaseFunction\AddToDataBase;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_POST["note"]) || empty(trim($_POST["note"]))){
            throw new Exception("Don't POST variable to data base");
        } else {
            $note = $_POST['note'];
            $template = "message.html.twig";
            $sqlInsertData = "INSERT INTO addToDataBase (note) VALUES (?)";
            
            $addToDataBase = new AddToDataBase($twig);
            $addToDataBase->addNote($note,$template,$sqlInsertData);
        }
    }
?> 